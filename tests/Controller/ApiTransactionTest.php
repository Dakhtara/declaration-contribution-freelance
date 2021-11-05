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
        $this->assertCount(3, $data);
        //We make sure the returned array has at least these keys
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('type', $data[0]);
        $this->assertArrayHasKey('label', $data[0]);
        $this->assertArrayHasKey('price', $data[0]);
        $this->assertArrayHasKey('dateTime', $data[0]);
        $this->assertArrayHasKey('slices', $data[0]);
        $this->assertArrayHasKey('splittedTransaction', $data[0]);

        $this->assertIsString($data[0]['type']);
        $this->assertIsString($data[0]['label']);
        $this->assertIsString($data[0]['dateTime']);
        $this->assertIsNumeric($data[0]['price']);
    }
}
