<?php

namespace App\Service;

use App\Manager\UserManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class QuarterSummaryNotifier
{
    public function __construct(protected UserManager $userManager,
                                protected CalculateQuarterDeclaration $calculateQuarterDeclaration,
                                protected MailerInterface $mailer
    )
    {
    }

    public function sendQuarterSummaryEmail(int $quarter, int $year)
    {
        $users = $this->userManager->getUserByEmailSummary();

        foreach($users as $user) {
            $summary = $this->calculateQuarterDeclaration->calculateForQuarter($quarter, $year, $user);

            $email = (new TemplatedEmail())
                ->from(new Address('contact@dakhtara.fr'))
                ->addTo(new Address($user->getEmail()))
                ->subject(sprintf("Déclaration pour le trimestre %d %d", $quarter, $year))
                ->htmlTemplate('email/quarter_summary.html.twig')
                ->context(['summary' => $summary])
            ;

            $this->mailer->send($email);
        }
    }
}