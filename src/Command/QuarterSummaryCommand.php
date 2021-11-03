<?php

namespace App\Command;

use App\Entity\Transaction;
use App\Service\CalculateQuarterDeclaration;
use App\SummaryQuarter\SummaryQuarterFormatter;
use App\Util\CurrencyFormatter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:quarter:summary',
    description: 'Show summary for a quarter',
)]
class QuarterSummaryCommand extends Command
{
    public function __construct(private CalculateQuarterDeclaration $calculateQuarterDeclaration, private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('quarter', InputArgument::REQUIRED, 'Quarter of the year, must be an integer 1, 2, 3 or 4')
            ->addArgument('year', InputArgument::REQUIRED, 'Year of the quarter');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $quarter = $input->getArgument('quarter');
        $year = $input->getArgument('year');

        // We need to fetch transactions and split transaction for the Quarter and year
        $summary = $this->calculateQuarterDeclaration->calculateForQuarter($quarter, $year);
        $currencyFormatter = new CurrencyFormatter();

        $creditTransaction = [];
        foreach ($summary->getTransactionByType() as $transaction) {
            $creditTransaction[] = [$transaction->getLabel(), $transaction->getDate()->format('d/m/Y'), $currencyFormatter->toCurrency($transaction->getPrice())];
        }

        $io->table(
            ['Libellé', 'Date', 'Montant'],
            $creditTransaction
        );

        $io->writeln("Total de crédit {$currencyFormatter->toCurrency($summary->getTotalCredit())}");

        $debitTransaction = [];
        foreach ($summary->getTransactionByType(Transaction::TYPE_DEBIT) as $transaction) {
            if ($transaction->getSlices() === null) {
                $debitTransaction[] = [$transaction->getLabel(), $transaction->getDate()->format('d/m/Y'), $currencyFormatter->toCurrency($transaction->getPrice())];
            } else {
                $splittedTransaction = $summary->getSplittedTransaction($transaction);
                if ($splittedTransaction !== null) {
                    $splittedTransaction->setIsCounted(true);

                    $debitTransaction[] = [$splittedTransaction->getTransaction()->getLabel(),
                        $splittedTransaction->getDate()->format('d/m/Y'),
                        SummaryQuarterFormatter::formatSplittedTransaction($transaction, $splittedTransaction),
                    ];
                }
            }
        }

        $io->table(
            ['Libellé', 'Date', 'Montant'],
            $debitTransaction
        );

        $io->writeln("Total de débit {$currencyFormatter->toCurrency($summary->getTotalDebit())}");


        $io->success("A déclarer pour ce trimestre {$currencyFormatter->toCurrency($summary->getAmount())}");
        $this->entityManager->flush();
        return Command::SUCCESS;
    }
}
