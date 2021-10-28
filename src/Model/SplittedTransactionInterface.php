<?php

namespace App\Model;

interface SplittedTransactionInterface
{
    public function getDate(): \DateTimeInterface;

    public function getAmount(): int;

    public function isCounted(): bool;

    public function getTransaction(): TransactionInterface;
}
