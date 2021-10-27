<?php

namespace App\Model;


interface TransactionInterface
{
    /**
     * Must be of type credit/debit
     */
    public function getType(): string;

    public function getPrice(): int;

    public function getDate(): \DateTime;
}
