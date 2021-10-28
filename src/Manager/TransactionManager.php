<?php

namespace App\Manager;

use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Util\QuarterDate;

class TransactionManager
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param int $quarter
     * @param int $year
     *
     * @return array|null|Transaction[]
     */
    public function getByQuarterAndYear(int $quarter, int $year): ?array
    {
        $dates = (new QuarterDate())->getDatesByQuarterAndYear($quarter, $year);
        return $this->transactionRepository->getByQuarter($dates['startDate'], $dates['endDate']);
    }

    public function save(Transaction $transaction): Transaction
    {
        return $this->transactionRepository->save($transaction);
    }
}
