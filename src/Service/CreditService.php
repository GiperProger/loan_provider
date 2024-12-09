<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Credit;
use App\Event\CreditApprovedEvent;
use App\Repository\CreditRepository;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreditService
{
    public const ALLOWED_STATES = ['CA', 'NY', 'NV'];

    public function __construct(
        private readonly CreditRepository         $clientRepository,
        private readonly ValidatorInterface       $validator,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function issueCredit(Client $client, array $data): array
    {
        $age = $client->getAge();
        $ficoScore = $client->getFicoScore();
        $address = $client->getAddress();
        $income = $client->getIncome();

        //Все эти проверки в идеале вынести в отдельный класс который занимается
        // исключительно принятием решений на основе предоставленных данных. Можно обработать отдельно каждое условие
        //что бы было понятно по какой причине случился отказ

        if ($ficoScore <= 500
            ||
            $age < 18
            ||
            $age > 60
            ||
            $income < 1000
            ||
            !in_array($address, self::ALLOWED_STATES)
        ) {
            return ['errors' => 'Credit denied'];
        }

        // Особое условие для штата NY
        if ($address === 'NY' && rand(0, 1) === 0) {
            return ['errors' => 'Credit denied (random denial for NY)'];
        }

        $credit = new Credit();
        $credit->setProductName($data['productName']);
        $credit->setTerm($data['term']);
        $credit->setAmount($data['amount']);

        // Увеличение процентной ставки для штата CA
        $interestRate = $data['interestRate'];
        if ($address === 'CA') {
            $interestRate += 11.49;
        }
        $credit->setInterestRate($interestRate);

        $credit->setClient($client);

        $errors = $this->validator->validate($credit);

        if (count($errors) > 0) {
            return ['errors' => (string) $errors];
        }

        $this->clientRepository->save($credit);

        //Кидаем ивент после одобрения кредита. В нашем случае это нужно для создания уведомления,
        // в последствии можно добавить что угодно. То же самое можно сделать на отказ в кредите и
        // перед тем как принимается решение по выдаче.
        $event = new CreditApprovedEvent($credit);
        $this->eventDispatcher->dispatch($event);

        return ['credit' => $credit] ;
    }
}
