<?php

namespace App\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ClientService
{
    public function __construct(
        private ClientRepository $clientRepository,
        private ValidatorInterface $validator
    )
    {
    }

    public function createClient(array $data): array
    {
        $client = new Client();
        $client->setLastName($data['lastName'] ?? null);
        $client->setFirstName($data['firstName'] ?? null);
        $client->setAge($data['age'] ?? null);
        $client->setSsn($data['ssn'] ?? null);
        $client->setAddress($data['address'] ?? null);
        $client->setFicoScore($data['ficoScore'] ?? null);
        $client->setEmail($data['email'] ?? null);
        $client->setPhoneNumber($data['phoneNumber'] ?? null);

        // Валидация
        $errors = $this->validator->validate($client);

        if (count($errors) > 0) {
            return ['errors' => (string) $errors];
        }

        $this->clientRepository->save($client);

        return ['client' => $client];
    }

    public function updateClient(Client $client, $data): array
    {
        $client->setLastName($data['lastName'] ?? $client->getLastName());
        $client->setFirstName($data['firstName'] ?? $client->getFirstName());
        $client->setAge($data['age'] ?? $client->getAge());
        $client->setSsn($data['ssn'] ?? $client->getSsn());
        $client->setAddress($data['address'] ?? $client->getAddress());
        $client->setFicoScore($data['ficoScore'] ?? $client->getFicoScore());
        $client->setEmail($data['email'] ?? $client->getEmail());
        $client->setPhoneNumber($data['phoneNumber'] ?? $client->getPhoneNumber());

        // Валидация данных
        $errors = $this->validator->validate($client);

        if (count($errors) > 0) {
            return ['errors' => (string) $errors];
        }

        $this->clientRepository->save($client);

        return ['client' => $client];
    }
}