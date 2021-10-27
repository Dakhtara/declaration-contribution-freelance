<?php

namespace App\SummaryQuarter;

use App\Entity\Transaction;
use App\Model\SummaryQuarterInterface;
use App\Model\TransactionInterface;

class SummaryQuarter implements SummaryQuarterInterface
{
    /**
     * @param array|TransactionInterface[] $transactions
     */
    public function __construct(private array $transactions)
    {
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    public function getAmount(): int
    {
        return $this->getTotalCredit() - $this->getTotalDebit();
    }

    public function getTotalCredit(): int
    {
        $credit = 0;
        foreach ($this->transactions as $transaction) {
            if ($transaction->getType() === Transaction::TYPE_CREDIT) {
                $credit += $transaction->getPrice();
            }
        }

        return $credit;
    }

    public function getTotalDebit(): int
    {
        $debit = 0;
        foreach ($this->transactions as $transaction) {
            if ($transaction->getType() === Transaction::TYPE_DEBIT) {
                $debit += $transaction->getPrice();
            }
        }

        return $debit;
    }

    public function getDetailDebit()
    {
    }
}
