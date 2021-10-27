<?php

namespace App\Entity;

use App\Model\TransactionInterface;

class Transaction implements TransactionInterface
{
    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';

    public function __construct(private string $type, private int $price, private \DateTime $dateTime)
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDate(): \DateTime
    {
        return $this->dateTime;
    }
}
