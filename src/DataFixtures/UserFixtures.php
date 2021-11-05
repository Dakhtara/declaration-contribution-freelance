<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [[
            'email' => 'anthony.matignon@domain.com',
            'roles' => ['ROLE_USER'],
            'password' => 'azerty',
        ],
            [
                'email' => 'admin@domain.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => 'azerty',
            ],
        ];

        foreach ($users as $user) {
            $userEntity = new User();

            $userEntity->setEmail($user['email'])
                ->setRoles($user['roles'])
                ->setPassword($this->hasher->hashPassword($userEntity, $user['password']));

            $manager->persist($userEntity);
        }
        $manager->flush();
    }
}
