<?php

namespace App\Service;

use App\Model\SummaryQuarterInterface;
use App\Model\TransactionInterface;
use App\SummaryQuarter\SummaryQuarter;

class CalculateQuarterDeclaration
{

    /**
     * @param TransactionInterface[] $transactions
     */
    public function calculate(array $transactions)
    {
        $summaryQuarter = new SummaryQuarter($transactions);

        return $summaryQuarter->getAmount();
    }

    public function calculateForQuarter(array $transactions, \DateTimeInterface $dateTime): SummaryQuarterInterface
    {
    }
}
