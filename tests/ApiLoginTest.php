<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiLoginTest extends WebTestCase
{
    use AuthenticatedUserTrait;

    public function testLogin(): void
    {
        $this->createAuthenticatedClient('anthony.matignon@domain.com', 'azerty');
        $this->assertResponseIsSuccessful();
    }
}
