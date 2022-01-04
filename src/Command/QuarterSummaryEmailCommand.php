<?php

namespace App\Command;

use App\Service\QuarterSummaryNotifier;
use App\Util\QuarterDate;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:quarter:summary-email')]
class QuarterSummaryEmailCommand extends Command
{
    public function __construct(private QuarterSummaryNotifier $quarterSummary,
    private QuarterDate $quarterDate
    )
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $now = new \DateTime();

        $quarterYear = $this->quarterDate->getPreviousQuarter($now);

        $this->quarterSummary->sendQuarterSummaryEmail($quarterYear['quarter'], $quarterYear['year']);
    }
}