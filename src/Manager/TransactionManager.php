<?php

namespace App\Manager;

use App\Entity\SplittedTransaction;
use App\Entity\Transaction;
use App\Entity\User;
use App\Repository\TransactionRepository;
use App\Util\NumberSplitter;
use App\Util\QuarterDate;
use Symfony\Component\Security\Core\Security;

class TransactionManager
{
    public function __construct(private TransactionRepository $transactionRepository, private Security $security)
    {
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
    public function getByUser(?User $user = null): ?array
    {
        $user = $user ?? $this->security->getUser();

        return $this->transactionRepository->getByUser($user);
    }

    /**
     * @return array|Transaction[]|null
     */
    public function getByQuarterAndYear(int $quarter, int $year, ?User $user = null): ?array
    {
        $user = $user ?? $this->security->getUser();
        $dates = (new QuarterDate())->getDatesByQuarterAndYear($quarter, $year);

        return $this->transactionRepository->getByQuarter($dates['startDate'], $dates['endDate'], $user);
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
