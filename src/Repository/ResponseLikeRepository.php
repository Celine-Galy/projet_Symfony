<?php

namespace App\Repository;

use App\Entity\ResponseLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponseLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseLike[]    findAll()
 * @method ResponseLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseLike::class);
    }

    // /**
    //  * @return ResponseLike[] Returns an array of ResponseLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponseLike
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
