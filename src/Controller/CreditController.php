<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Credit;
use App\Service\CreditService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreditController extends AbstractController
{
    #[Route('/api/credits', name: 'issue_credit', methods: ['POST'])]
    public function issueCredit(Request $request, EntityManagerInterface $em, CreditService $creditService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $client = $em->getRepository(Client::class)->find($data['clientId']);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], 404);
        }

        $credit = $creditService->issueCredit($client, $data);

        if (isset($credit['errors'])){
            return new JsonResponse(['errors' => $credit['errors']], 400);
        }

        return new JsonResponse(['message' => 'Credit issued successfully'], 201);
    }

    #[Route('/api/credits', name: 'get_credits', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['message' => 'Welcome to the Credit API']);
    }
}
