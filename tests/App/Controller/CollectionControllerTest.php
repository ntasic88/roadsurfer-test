<?php

namespace App\Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CollectionControllerTest extends WebTestCase
{
    public function testListCollections(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/collections', ['type' => 'fruit']);

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);
    }

    public function testAddToCollections(): void
    {
        $client = static::createClient();

        $payload = [
            [
                'name' => 'Apple',
                'type' => 'fruit',
                'quantity' => 500,
            ],
            [
                'name' => 'Carrot',
                'type' => 'vegetable',
                'quantity' => 300,
            ],
        ];

        $client->request(
            'POST',
            '/api/collections',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($payload)
        );

        $response = $client->getResponse();
        $this->assertResponseIsSuccessful();

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('success', $data['status']);
    }

    public function testListAfterAdding(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/collections', ['type' => 'fruit']);
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());

        $data = json_decode($response->getContent(), true);

        $this->assertIsArray($data);
    }
}

