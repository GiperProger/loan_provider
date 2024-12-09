<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Service\ClientService;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/api/clients', name: 'create_client', methods: ['POST'])]
    public function create(Request $request, ClientService $clientService, NotificationService $notificationService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $client = $clientService->createClient($data);

        if (isset($client['errors'])){
            return new JsonResponse(['errors' => $client['errors']], 400);
        }

        return new JsonResponse(['message' => 'Client created successfully'], 201);
    }

    #[Route('/api/clients/{id}', name: 'update_client', methods: ['PUT'])]
    public function update(
        int $id,
        Request $request,
        ClientService $clientService,
        ClientRepository $clientRepository
    ): JsonResponse {
        $client = $clientRepository->find($id);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        $client = $clientService->updateClient($client, $data);

        if (isset($client['errors'])){
            return new JsonResponse(['errors' => $client['errors']], 400);
        }

        return new JsonResponse(['message' => 'Client updated successfully'], 200);
    }
}
