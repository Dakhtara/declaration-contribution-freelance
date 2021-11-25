<?php

namespace App\Tests;

use App\Entity\Transaction;
use App\Manager\TransactionManager;

class TransactionManagerTest extends AppWebTestCase
{

    public function testEntityByQuarterAndYear()
    {
        $quarter = 4;
        $year = 2021;
        $this->logInAs();
        $container = self::getContainer();
        $transactionManager = $container->get('test.'.TransactionManager::class);

        $results = $transactionManager->getByQuarterAndYear($quarter, $year);

        $this->assertSame(3, count($results));
    }

    public function testInsert()
    {
        $container = self::getContainer();
        /** @var TransactionManager $transactionManager */
        $transactionManager = $container->get('test.'.TransactionManager::class);
        $transaction = new Transaction();

        $transaction->setType(Transaction::TYPE_CREDIT)
            ->setLabel('Virement X')
            ->setPrice(70000)
            ->setDateTime(new \DateTime());

        $transaction = $transactionManager->save($transaction);
        $this->assertNotNull($transaction->getId());
    }
}
