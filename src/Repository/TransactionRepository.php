<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getByQuarter(\DateTimeInterface $start, \DateTimeInterface $end): ?array
    {
        $qb = $this->createQueryBuilder('t');

        $qb->where($qb->expr()->between('t.dateTime', ':start', ':end'))
            ->setParameters( ['start' => $start, 'end' => $end]);

        return $qb->getQuery()->getResult();
    }

    public function save(Transaction $transaction)
    {
        $this->_em->persist($transaction);
        $this->_em->flush();

        return $transaction;
    }
}
