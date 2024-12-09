<?php

namespace App\Tests\Service;

use App\Entity\Client;
use App\Repository\ClientRepository;
use App\Service\ClientService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientServiceTest extends TestCase
{
    public function testCreateClientSuccess(): void
    {
        $clientRepository = $this->createMock(ClientRepository::class);
        $validator = $this->createMock(ValidatorInterface::class);

        $service = new ClientService($clientRepository, $validator);

        $data = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'age' => 30,
            'ssn' => 123456789,
            'address' => 'CA',
            'ficoScore' => 700,
            'email' => 'john.doe@example.com',
            'phoneNumber' => '+12345678901',
            'income' => '2000',
        ];

        $result = $service->createClient($data);

        $this->assertArrayHasKey('client', $result);
        $this->assertInstanceOf(Client::class, $result['client']);
        $this->assertEquals('Doe', $result['client']->getLastName());
    }
}
