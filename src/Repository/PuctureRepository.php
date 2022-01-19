<?php

namespace App\Repository;

use App\Entity\Pucture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pucture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pucture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pucture[]    findAll()
 * @method Pucture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PuctureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pucture::class);
    }

    // /**
    //  * @return Pucture[] Returns an array of Pucture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pucture
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
