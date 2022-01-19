<?php

namespace App\Repository;

use App\Entity\Blinderie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blinderie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blinderie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blinderie[]    findAll()
 * @method Blinderie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlinderieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blinderie::class);
    }

    // /**
    //  * @return Blinderie[] Returns an array of Blinderie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Blinderie
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
