<?php

namespace App\Model;

interface SummaryQuarterInterface
{
    public function getTransactions(): array;

    public function getAmount(): int;

    public function getTotalCredit(): int;

    public function getTotalDebit(): int;

    /**
     * @param string $type
     *
     * @return iterable|TransactionInterface[]
     */
    public function getTransactionByType(string $type): iterable;

    public function getSplittedTransaction(TransactionInterface $transaction): ?SplittedTransactionInterface;
}
