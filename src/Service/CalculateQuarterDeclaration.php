<?php

namespace App\Service;

use App\Entity\User;
use App\Manager\TransactionManager;
use App\Model\SummaryQuarterInterface;
use App\SummaryQuarter\SummaryQuarter;

class CalculateQuarterDeclaration
{
    public function __construct(private TransactionManager $transactionManager)
    {
    }

    public function calculateForQuarter(int $quarter, int $year, ?User $user = null): SummaryQuarterInterface
    {
        $transactions = $this->transactionManager->getByQuarterAndYear($quarter, $year, $user);

        return new SummaryQuarter($transactions, $quarter, $year);
    }
}
