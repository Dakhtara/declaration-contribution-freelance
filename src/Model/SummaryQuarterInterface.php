<?php

namespace App\Model;

interface SummaryQuarterInterface
{
    public function getTransactions(): array;

    public function getAmount(): int;

    public function getTotalCredit(): int;

    public function getTotalDebit(): int;

    public function getDetailDebit();
}
