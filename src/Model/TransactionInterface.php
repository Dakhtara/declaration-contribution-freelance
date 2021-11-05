<?php

namespace App\Model;

use Doctrine\Common\Collections\Collection;

interface TransactionInterface
{
    /**
     * Must be of type credit/debit.
     */
    public function getType(): string;

    public function getPrice(): int;

    public function getDate(): \DateTimeInterface;

    public function getSlices(): ?int;

    /**
     * @return Collection|SplittedTransactionInterface[]
     */
    public function getSplittedTransaction(): Collection;
}
