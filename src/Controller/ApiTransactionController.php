<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Manager\TransactionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[IsGranted('ROLE_USER')]
#[Route('/api/transactions', name: 'api_transactions_')]
class ApiTransactionController extends AbstractController
{

    public function __construct(protected TransactionManager $transactionManager,
                                protected SerializerInterface $serializer
    )
    {
    }

    #[Route(methods: ['GET'], name: 'list')]
    public function index(Request $request): Response
    {
        if (($date = $request->query->get('date')) !== null) {
            $transactions = $this->transactionManager->getByUserAndTrimester($this->getUser(), new \DateTime($date));
        } else {
            $transactions = $this->transactionManager->getByUser($this->getUser());
        }

        return $this->json($transactions, context: ['groups' => 'read:transaction']);
    }

    #[Route(name: 'new', methods: ['POST'])]
    public function addTransaction(Request $request): JsonResponse
    {
        $transaction = $this->serializer->deserialize($request->getContent(), Transaction::class,'json');

        $this->transactionManager->save($transaction);
        $user = $this->getUser();

        $user->addTransaction($transaction);

        return $this->json($transaction, 201, context: ['groups' => 'read:transaction']);
    }
}
