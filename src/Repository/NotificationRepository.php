<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Repository\trait\RepoTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 */
class NotificationRepository extends ServiceEntityRepository
{
    use RepoTrait;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @return Notification[] Returns an array of Notification objects
     */
    public function findNotificationsToSend(): array
    {
        return $this->createQueryBuilder('notif')
            ->andWhere('notif.sent = 0')
            ->orderBy('notif.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
