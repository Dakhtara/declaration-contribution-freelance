<?php

namespace App\SummaryQuarter;

use App\Entity\Transaction;
use App\Model\SplittedTransactionInterface;
use App\Model\SummaryQuarterInterface;
use App\Model\TransactionInterface;
use App\Util\QuarterDate;

class SummaryQuarter implements SummaryQuarterInterface
{
    /**
     * @param array|TransactionInterface[] $transactions
     */
    public function __construct(private array $transactions, private int $quarter, private int $year)
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
        foreach ($this->getTransactionByType() as $transaction) {
            $credit += $transaction->getPrice();
        }

        return $credit;
    }

    /**
     * @param string $type
     *
     * @return iterable|TransactionInterface[]
     */
    public function getTransactionByType($type = Transaction::TYPE_CREDIT): iterable
    {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getType() === $type) {
                yield $transaction;
            }
        }
    }

    public function getTotalDebit(): int
    {
        $debit = 0;
        foreach ($this->getTransactionByType(Transaction::TYPE_DEBIT) as $transaction) {
            if (null === $transaction->getSlices()) {
                $debit += $transaction->getPrice();
            } else {
                $splittedTransaction = $this->getSplittedTransaction($transaction);
                if (null === $splittedTransaction) {
                    throw new \Exception("A transaction exist with slices but no splitted transactions exist. There must be an error on transaction #{$transaction->getId()}");
                }

                $debit += $splittedTransaction->getAmount();
            }
        }

        return $debit;
    }

    public function getSplittedTransaction(TransactionInterface $transaction): ?SplittedTransactionInterface
    {
        $dates = (new QuarterDate())->getDatesByQuarterAndYear($this->quarter, $this->year);

        if (null === $transaction->getSlices() || 0 === count($transaction->getSplittedTransaction())) {
            return null;
        }

        foreach ($transaction->getSplittedTransaction() as $splittedTransaction) {
            $splittedTrDate = $splittedTransaction->getDate()->format('U');
            if ($dates['startDate']->format('U') < $splittedTrDate && $splittedTrDate < $dates['endDate']->format('U')) {
                return $splittedTransaction;
            }
        }

        return null;
    }
}
