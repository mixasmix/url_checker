<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Url;

/**
 * @method Url | null find($id, $lockMode = null, $lockVersion = null)
 * @method Url | null findOneBy(array $criteria, array $orderBy = null)
 * @method Url[]      findAll()
 * @method Url[]      findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    /**
     * @param int $urlId
     *
     * @return Url
     *
     * @throws EntityNotFoundException
     */
    public function getById(int $urlId): Url
    {
        $url = $this->findOneBy(['id' => $urlId]);

        if (empty($url)) {
            throw new EntityNotFoundException(sprintf('Адрес с id %d не найден', $urlId));
        }

        return $url;
    }
}
