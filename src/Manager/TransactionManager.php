<?php

namespace App\Manager;

use App\Entity\SplittedTransaction;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Util\NumberSplitter;
use App\Util\QuarterDate;

class TransactionManager
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @return array|Transaction[]|null
     */
    public function findAll(): ?array
    {
        return $this->transactionRepository->findAll();
    }

    /**
     * @return array|Transaction[]|null
     */
    public function getByQuarterAndYear(int $quarter, int $year): ?array
    {
        $dates = (new QuarterDate())->getDatesByQuarterAndYear($quarter, $year);

        return $this->transactionRepository->getByQuarter($dates['startDate'], $dates['endDate']);
    }

    public function save(Transaction $transaction): Transaction
    {
        if (null === $transaction->getId()) {
            if (null !== $transaction->getSlices()) {
                $numberSplitter = new NumberSplitter();
                $transDate = \DateTimeImmutable::createFromInterface($transaction->getDate());

                $splittedNumbers = $numberSplitter->splitRound($transaction->getPrice(), $transaction->getSlices());

                for ($i = 0; $i < $transaction->getSlices(); ++$i) {
                    $splittedTransaction = new SplittedTransaction();
                    $splittedTransaction->setIsCounted(false)
                        ->setAmount($splittedNumbers[$i])
                        ->setDate($transDate->modify("+ $i year"));
                    $transaction->addSplittedTransaction($splittedTransaction);
                }
            }
        }

        return $this->transactionRepository->save($transaction);
    }
}
