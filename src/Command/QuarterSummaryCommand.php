<?php

namespace App\Command;

use App\SummaryQuarter\SummaryQuarter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:quarter:summary',
    description: 'Show summary for a quarter',
)]
class QuarterSummaryCommand extends Command
{
    public function __construct()
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

        return Command::SUCCESS;
    }
}
