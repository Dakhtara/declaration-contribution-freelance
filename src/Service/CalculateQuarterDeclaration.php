<?php

namespace App\Service;

use App\Manager\TransactionManager;
use App\Model\SummaryQuarterInterface;
use App\SummaryQuarter\SummaryQuarter;

class CalculateQuarterDeclaration
{
    public function __construct(private TransactionManager $transactionManager)
    {
    }

    public function calculateForQuarter(int $quarter, int $year): SummaryQuarterInterface
    {
        $transactions = $this->transactionManager->getByQuarterAndYear($quarter, $year);

        return new SummaryQuarter($transactions, $quarter, $year);
    }
}
