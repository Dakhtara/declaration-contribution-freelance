<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'anthony.matignon@domain.com',
                'roles' => ['ROLE_USER'],
                'password' => 'azerty',
                'transactions' => ['tr-1', 'tr-2', 'tr-3'],
            ],
            [
                'email' => 'admin@domain.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'azerty',
                'transactions' => [],
            ],
            [
                'email' => 'other.user@domain.com',
                'roles' => ['ROLE_USER'],
                'password' => 'azerty',
                'transactions' => ['tr-4'],
            ],
        ];

        foreach ($users as $user) {
            $userEntity = new User();

            $userEntity->setEmail($user['email'])
                ->setRoles($user['roles'])
                ->setPassword($this->hasher->hashPassword($userEntity, $user['password']));

            if (!empty($user['transactions'])) {
                foreach ($user['transactions'] as $transactionRef) {
                    $userEntity->addTransaction($this->getReference($transactionRef));
                }
            }

            $manager->persist($userEntity);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [TransactionFixtures::class];
    }
}
