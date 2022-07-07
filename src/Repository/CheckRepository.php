<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Check;

/**
 * @method Check | null find($id, $lockMode = null, $lockVersion = null)
 * @method Check | null findOneBy(array $criteria, array $orderBy = null)
 * @method Check[]      findAll()
 * @method Check[]      findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Check::class);
    }
}
