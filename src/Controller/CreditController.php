<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CreditController
{
    #[Route('/api/credits', name: 'get_credits', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['message' => 'Welcome to the Credit API']);
    }
}