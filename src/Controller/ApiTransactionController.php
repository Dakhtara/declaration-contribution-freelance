<?php

namespace App\Controller;

use App\Manager\TransactionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class ApiTransactionController extends AbstractController
{
    #[Route('/api/transactions', name: 'api_transactions')]
    public function index(TransactionManager $transactionManager, Request $request): Response
    {
        if (($date = $request->query->get('date')) !== null) {
            $transactions = $transactionManager->getByUserAndTrimester($this->getUser(), new \DateTime($date));
        } else {
            $transactions = $transactionManager->getByUser($this->getUser());
        }

        return $this->json($transactions, context: ['groups' => 'read:transaction']);
    }
}
