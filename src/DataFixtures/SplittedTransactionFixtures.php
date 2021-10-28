<?php

namespace App\DataFixtures;

use App\Entity\SplittedTransaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SplittedTransactionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $splittedTransactions = [
            [
                'id' => 1,
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '28/10/2021 10:25:00'),
                'amount' => 200,
                'counted' => false,
                'transaction' => 'tr-3',
            ],
            [
                'id' => 2,
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '28/10/2022 13:39:00'),
                'amount' => 200,
                'counted' => false,
                'transaction' => 'tr-3',
            ],
            [
                'id' => 3,
                'date' => \DateTime::createFromFormat('d/m/Y H:i:s', '28/10/2023 13:39:00'),
                'amount' => 200,
                'counted' => false,
                'transaction' => 'tr-3',
            ],
        ];

        foreach ($splittedTransactions as $splittedTransaction) {
            $entitySplitted = new SplittedTransaction();

            $transaction = $this->getReference($splittedTransaction['transaction']);
            $entitySplitted->setDate($splittedTransaction['date'])
                ->setAmount($splittedTransaction['amount'])
                ->setIsCounted($splittedTransaction['counted'])
                ->setTransaction($transaction);

            $manager->persist($entitySplitted);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [TransactionFixtures::class];
    }
}
