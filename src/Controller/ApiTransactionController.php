<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\TransactionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[IsGranted('ROLE_ADMIN')]
class ApiTransactionController extends AbstractController
{
    #[Route('/api/transactions', name: 'api_transactions')]
    public function index(#[CurrentUser] ?User $user, TransactionManager $transactionManager): Response
    {
        $transactions = $transactionManager->findAll();

        return $this->json($transactions, context: ['groups' => 'read:transaction']);
    }
}
