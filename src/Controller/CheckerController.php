<?php

namespace App\Controller;

use App\DTO\AddUrlData;
use Exception;
use App\Facade\CheckUrlFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CheckerController extends AbstractController
{
    /**
     * @param CheckUrlFacade $checkUrlFacade
     */
    public function __construct(private CheckUrlFacade $checkUrlFacade)
    {
    }

    /**
     * @param AddUrlData $data
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    #[Route(path: '/add', methods: ['POST'])]
    public function createUrl(AddUrlData $data): JsonResponse
    {
        return $this->json($this->checkUrlFacade->create($data));
    }
}
