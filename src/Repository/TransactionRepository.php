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

        $qb->leftJoin('t.splittedTransaction', 'st');
        //We fetch in root entity
        $qb->where($qb->expr()->between('t.dateTime', ':start', ':end'));
        //Or in splittedTransaction
        $qb->orWhere($qb->expr()->between('st.date', ':start', ':end'));

        $qb->setParameters(['start' => $start, 'end' => $end]);

        return $qb->getQuery()->getResult();
    }

    public function save(Transaction $transaction)
    {
        $this->_em->persist($transaction);
        $this->_em->flush();

        return $transaction;
    }
}
