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
        private CreditRepository $clientRepository,
        private ValidatorInterface $validator,
        private EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function issueCredit(Client $client, array $data): array
    {
        // Проверка условий выдачи кредита
        $age = $client->getAge();
        $ficoScore = $client->getFicoScore();
        $address = $client->getAddress();

        if ($ficoScore <= 500 || $age < 18 || $age > 60 || !in_array($address, self::ALLOWED_STATES)) {
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

        $event = new CreditApprovedEvent($credit);
        $this->eventDispatcher->dispatch($event);

        return ['credit' => $credit] ;
    }
}