<?php

namespace App\Tests\Controller;

use App\Tests\AuthenticatedUserTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTransactionTest extends WebTestCase
{
    use AuthenticatedUserTrait;

    public function testAdminAccess(): void
    {
        $client = $this->createAuthenticatedClient();
        $client->request('GET', '/api/transactions');

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(0, $data);
    }

    public function testTransactions(): void
    {
        $client = $this->createAuthenticatedClient('anthony.matignon@domain.com');
        //Here we should only have 3 transactions
        $client->request(
            'GET',
            '/api/transactions',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(5, $content);
        //We make sure the returned array has at least these keys
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('type', $content[0]);
        $this->assertArrayHasKey('label', $content[0]);
        $this->assertArrayHasKey('price', $content[0]);
        $this->assertArrayHasKey('dateTime', $content[0]);
        $this->assertArrayHasKey('slices', $content[0]);
        $this->assertArrayHasKey('splittedTransaction', $content[0]);

        $this->assertIsString($content[0]['type']);
        $this->assertIsString($content[0]['label']);
        $this->assertIsString($content[0]['dateTime']);
        $this->assertIsNumeric($content[0]['price']);
    }

    public function testTrimesterTransactions(): void
    {
        $client = $this->createAuthenticatedClient('anthony.matignon@domain.com');
        //Here we should only have 3 transactions
        $client->request(
            'GET',
            '/api/transactions?date=2021-08-01T00:00:00.000Z ',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
        );

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount(2, $content);
        //We make sure the returned array has at least these keys
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('type', $content[0]);
        $this->assertArrayHasKey('label', $content[0]);
        $this->assertArrayHasKey('price', $content[0]);
        $this->assertArrayHasKey('dateTime', $content[0]);
        $this->assertArrayHasKey('slices', $content[0]);
        $this->assertArrayHasKey('splittedTransaction', $content[0]);

        $this->assertIsString($content[0]['type']);
        $this->assertIsString($content[0]['label']);
        $this->assertIsString($content[0]['dateTime']);
        $this->assertIsNumeric($content[0]['price']);
    }
}
