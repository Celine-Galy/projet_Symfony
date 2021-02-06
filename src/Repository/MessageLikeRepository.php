<?php

namespace App\Repository;

use App\Entity\MessageLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageLike[]    findAll()
 * @method MessageLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageLike::class);
    }

    // /**
    //  * @return MessageLike[] Returns an array of MessageLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessageLike
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
