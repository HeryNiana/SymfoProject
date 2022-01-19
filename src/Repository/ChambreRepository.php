<?php
namespace App\Repository;
use App\Entity\Chambre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chambre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chambre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chambre[]    findAll()
 * @method Chambre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChambreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chambre::class);
    }


    public function findByChambre($numero)
    {
        return $this->createQueryBuilder('c')
            ->select('c.id','c.codech','c.photo','c.stateMenage','c.HeureMenage')
            ->where('c.femmeid= :date2')
            ->setParameters(
                array(
                    'date2'=>$numero
                )
            )
            ->getQuery()
            ->getResult()
        ;
    }

    public function menagechambre()
    {
        return $this->createQueryBuilder('c')
        ->select('c.id','f.nom','f.prenom','c.codech','c.photo','c.stateMenage','c.HeureMenage')
        ->join('c.femmeid','f')
        ->orderBy('f.nom')
        ->getQuery()
        ->getResult()
        ;
    }
  
}
