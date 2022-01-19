<?php

namespace App\Repository;

use App\Entity\Dateday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dateday|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dateday|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dateday[]    findAll()
 * @method Dateday[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatedayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dateday::class);
    }

    // /**
    //  * @return Dateday[] Returns an array of Dateday objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dateday
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
