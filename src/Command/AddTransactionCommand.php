<?php

namespace App\Command;

use App\Entity\Transaction;
use App\Manager\TransactionManager;
use App\Util\CurrencyFormatter;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:transaction:add', description: 'Add a transaction')]
class AddTransactionCommand extends Command
{

    public function __construct(private TransactionManager $transactionManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $labelQuestion = new Question("Quelle est le libellé de votre transaction ?");
        $typeQuestion = new ChoiceQuestion("Quelle est le type de votre transaction ?", [Transaction::TYPE_DEBIT, Transaction::TYPE_CREDIT]);
        $priceQuestion = new Question("Quelle est le montant de votre transaction ? (en milliers 10€ => 1000)", 0);
        $questionHelper = new QuestionHelper();

        $label = $questionHelper->ask($input, $output, $labelQuestion);
        $type = $questionHelper->ask($input, $output, $typeQuestion);
        $price = $questionHelper->ask($input, $output, $priceQuestion);

        $dateQuestion = new Question("Quelle est la date de votre transaction ? (d/m/Y)");
        $date = null;
        while (!$date instanceof \DateTimeInterface) {
            $dateText = $questionHelper->ask($input, $output, $dateQuestion);
            $date = \DateTime::createFromFormat('d/m/Y', $dateText);
            if (!$date) {
                $io->error(sprintf("Date '%s' ne correspond pas au format attendu (d/m/Y)", $dateText));
            }
        }

        $transaction = new Transaction();
        $transaction->setLabel($label)
            ->setDateTime($date)
            ->setPrice($price)
            ->setType($type);

        //If it's a debit with amount > 500€
        if ($type === Transaction::TYPE_DEBIT && $price >= 50000) {
            $io->writeln("Votre transaction est un débit avec un montant supérieur a 500€ il faut préciser en combien de fois vous devez les déclarer.");
            $sliceQuestion = new Question("Combien de partis faut-il découper pour ce montant ? (0 si pas de découpage a faire)", 3);
            $slices = $questionHelper->ask($input, $output, $sliceQuestion);
            if ($slices > 0) {
                $transaction->setSlices($slices);
            }
        }

        $this->transactionManager->save($transaction);

        $currencyFormatter = new CurrencyFormatter();
        $io->success(sprintf("Transaction enregistrée avec succès pour %s au %s pour %s", $transaction->getLabel(), $transaction->getDate()->format('d/m/Y'),
            $currencyFormatter->toCurrency($transaction->getPrice())));
        return Command::SUCCESS;
    }
}
