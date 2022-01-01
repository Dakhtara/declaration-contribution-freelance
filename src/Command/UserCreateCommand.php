<?php

namespace App\Command;

use App\Entity\User;
use App\Manager\UserManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Show summary for a quarter',
)]
class UserCreateCommand extends Command
{
    public function __construct(private UserManager $userManager, private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, "L'adresse email de l'utilisateur")
            ->addArgument('password', InputArgument::REQUIRED, "Le mot de passe de l'utilisateur")
            ->addArgument('roles', InputArgument::REQUIRED, 'Le ou les roles espacé par une virgule ","');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $roles = explode(",", $input->getArgument('roles'));

        $user = new User();
        $user->setEmail($email)
            ->setPassword($this->passwordHasher->hashPassword($user, $password))
            ->setRoles($roles);

        $this->userManager->save($user);

        $io->success("Utilisateur enregistré !");
        return Command::SUCCESS;
    }
}