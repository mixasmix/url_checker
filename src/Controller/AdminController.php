<?php

namespace App\Controller;

use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @param UrlRepository $urlRepository
     */
    public function __construct(private UrlRepository $urlRepository)
    {
    }

    /**
     * @return JsonResponse
     */
    #[Route(path: '/admin/url', methods: ['GET'])]
    public function getUrls(): JsonResponse
    {
        return $this->json([
            $this->urlRepository->findAll(),
        ]);
    }
}
