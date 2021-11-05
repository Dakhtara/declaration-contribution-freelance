<?php

namespace App\DataFixtures;

use App\Entity\Transaction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransactionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $transactions = [
            [
                'id' => 1,
                'type' => Transaction::TYPE_DEBIT,
                'label' => 'Achat Apple Pencil',
                'price' => 20000,
                'datetime' => \DateTime::createFromFormat('d/m/Y H:i:s', '28/10/2021 13:39:00'),
                'slices' => null,
            ],
            [
                'id' => 2,
                'label' => 'Virement ID City',
                'type' => Transaction::TYPE_CREDIT,
                'price' => 70000,
                'datetime' => \DateTime::createFromFormat('d/m/Y H:i:s', '27/10/2021 14:50:00'),
                'slices' => null,
            ],
            [
                'id' => 3,
                'label' => 'Achat Ipad Air',
                'type' => Transaction::TYPE_DEBIT,
                'price' => 60000,
                'datetime' => \DateTime::createFromFormat('d/m/Y H:i:s', '28/10/2021 10:25:00'),
                'slices' => 3,
            ],
        ];

        foreach ($transactions as $transaction) {
            $entityTransaction = new Transaction();
            $entityTransaction->setType($transaction['type'])
                ->setLabel($transaction['label'])
                ->setPrice($transaction['price'])
                ->setDateTime($transaction['datetime'])
                ->setSlices($transaction['slices']);

            $manager->persist($entityTransaction);
            $this->setReference('tr-'.$transaction['id'], $entityTransaction);
        }

        $manager->flush();
    }
}
