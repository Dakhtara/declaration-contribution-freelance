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
                if ($transaction->getPrice() < 50000) {
                    $debit += $transaction->getPrice();
                } else {
                    $debit += $transaction->getPrice() / $transaction->getSlices();
                }
            }
        }

        return $debit;
    }

    public function getDetailDebit()
    {
    }

    public function summaryByQuarterAndYear(int $quarter, int $year)
    {

    }
}
