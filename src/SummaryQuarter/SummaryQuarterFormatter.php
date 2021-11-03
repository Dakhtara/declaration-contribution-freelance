<?php

namespace App\SummaryQuarter;

use App\Model\SplittedTransactionInterface;
use App\Model\TransactionInterface;
use App\Util\CurrencyFormatter;

class SummaryQuarterFormatter
{
    public static function formatSplittedTransaction(TransactionInterface $transaction, SplittedTransactionInterface $splittedTransaction): string
    {
        $currentPrice = $splittedTransaction->getAmount();

        $remainingPrice = 0;
        foreach ($transaction->getSplittedTransaction() as $splittedTransaction) {
            if (!$splittedTransaction->isCounted()) {
                $remainingPrice += $splittedTransaction->getAmount();
            }
        }
        $currencyFormatter = new CurrencyFormatter();
        return sprintf("%s (%s restant à déclarer)", $currencyFormatter->toCurrency($currentPrice), $currencyFormatter->toCurrency($remainingPrice));
    }
}
