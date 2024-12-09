<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    public function testCreateClient(): void
    {
        $client = static::createClient();

        $data = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'age' => 30,
            'address' => 'CA',
            'ficoScore' => 720,
            'ssn' => 123456789,
            'email' => 'john.doe@example.com',
            'phoneNumber' => '+12345678901',
            'income' => 2000
        ];

        $client->request('POST', '/api/clients', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        $responseContent = $client->getResponse()->getContent();
        $this->assertJson($responseContent);

        $responseData = json_decode($responseContent, true);
        $this->assertArrayHasKey('success', $responseData);
    }
}