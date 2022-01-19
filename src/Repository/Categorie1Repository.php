<?php

namespace App\Repository;

use App\Entity\Categorie1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie1[]    findAll()
 * @method Categorie1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Categorie1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie1::class);
    }

    // /**
    //  * @return Categorie1[] Returns an array of Categorie1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Categorie1
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
