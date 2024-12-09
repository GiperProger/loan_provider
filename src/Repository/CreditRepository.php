<?php

namespace App\Repository;

use App\Entity\Credit;
use App\Repository\trait\RepoTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 */
class CreditRepository extends ServiceEntityRepository
{
    use RepoTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }
}
