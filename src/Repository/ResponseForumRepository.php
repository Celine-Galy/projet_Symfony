<?php

namespace App\Repository;

use App\Entity\ResponseForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ResponseForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseForum[]    findAll()
 * @method ResponseForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseForumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseForum::class);
    }

    // /**
    //  * @return ResponseForum[] Returns an array of ResponseForum objects
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
    public function findOneBySomeField($value): ?ResponseForum
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
