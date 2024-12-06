<?php

namespace App\Controller;

use App\Service\CollectionManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CollectionController
{
    private CollectionManager $manager;

    public function __construct(CollectionManager $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/api/collections', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $type = $request->query->get('type', 'fruit');

        return new JsonResponse($this->manager->getCollection($type));
    }

    #[Route('/api/collections', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $this->manager->process($data);

        return new JsonResponse(['status' => 'success']);
    }

    #[Route('/api/collections/search', methods: ['GET'])]
    public function search(Request $request): JsonResponse
    {
        $keyword = $request->query->get('keyword', '');
        $type = $request->query->get('type', 'fruit');

        if (!$keyword) {
            return new JsonResponse(['error' => 'Keyword is required'], 400);
        }

        $results = $this->manager->search($keyword, $type);
        return new JsonResponse($results);
    }

    #[Route('/api/collections/{name}', methods: ['DELETE'])]
    public function delete(string $name): JsonResponse
    {
        $this->manager->delete($name);

        return new JsonResponse(['status' => 'success']);
    }
}
