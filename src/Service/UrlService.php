<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Url;
use Throwable;

class UrlService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param string $urlAddress
     * @param int    $frequency
     * @param int    $quantityRepeated
     *
     * @return Url
     *
     * @throws Exception
     */
    public function create(
        string $urlAddress,
        int $frequency,
        int $quantityRepeated,
    ): Url {
        try {
            $this->entityManager->beginTransaction();

            $url = new Url(
                url: $urlAddress,
                frequency: $frequency,
                quantityRepeated: $quantityRepeated,
            );

            $this->entityManager->persist($url);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Throwable $exception) {
            $this->entityManager->rollback();

            throw $exception;
        }

        return $url;
    }
}
