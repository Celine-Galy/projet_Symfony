<?php

namespace App\Repository;

use App\Entity\ResponseTo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponseTo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseTo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseTo[]    findAll()
 * @method ResponseTo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseToRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseTo::class);
    }

    // /**
    //  * @return ResponseTo[] Returns an array of ResponseTo objects
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
    public function findOneBySomeField($value): ?ResponseTo
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
