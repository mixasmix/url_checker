<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Entity\Check;
use App\Entity\Url;

class CheckService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @param Url $url
     * @param int $statusCode
     *
     * @return Check
     *
     * @throws Exception
     */
    public function create(Url $url, int $statusCode): Check
    {
        try {
            $this->entityManager->beginTransaction();

            $check = new Check(
                $statusCode,
                $url->getChecks()->count(),
                $url,
            );

            $this->entityManager->persist($check);
            $this->entityManager->flush();
        } catch (Exception $exception) {
            $this->entityManager->rollback();

            throw $exception;
        }

        return $check;
    }
}
