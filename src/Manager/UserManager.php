<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;

class UserManager
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findOneByEmail($email);
    }

    public function save(User $user)
    {
        $this->userRepository->save($user);
    }
}