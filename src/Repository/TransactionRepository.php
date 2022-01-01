<?php

namespace App\Repository;

use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function getByQuarter(\DateTimeInterface $start, \DateTimeInterface $end, User $user): ?array
    {
        $qb = $this->createQueryBuilder('t');

        $qb->leftJoin('t.splittedTransaction', 'st')
            ->leftJoin('t.user', 'user');

        $qb->where($qb->expr()->eq('user', ':user'))
            ->andWhere(
                $qb->expr()->orX(
                    //We fetch in root entity
                    $qb->expr()->between('t.dateTime', ':start', ':end'),
                    //Or in splittedTransaction
                    $qb->expr()->between('st.date', ':start', ':end'),
                )
            );

        $qb->setParameters(['start' => $start, 'end' => $end, 'user' => $user]);

        return $qb->getQuery()->getResult();
    }

    public function getByUser(User $user): ?array
    {
        $qb = $this->createQueryBuilder('t');

        $qb->leftJoin('t.user', 'user')
            ->where($qb->expr()->eq('user', ':user'))
            ->setParameter('user', $user->getId());

        return $qb->getQuery()->getResult();
    }

    public function save(Transaction $transaction)
    {
        $this->_em->persist($transaction);
        $this->_em->flush();

        return $transaction;
    }
}
