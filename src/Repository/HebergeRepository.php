<?php

namespace App\Repository;

use App\Entity\Heberge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Heberge1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Heberge1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Heberge1[]    findAll()
 * @method Heberge1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HebergeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Heberge::class);
    }

    public function findByRecette()
    {
        return $this->createQueryBuilder('h')
        ->select('sum(h.montant) as montant','c.codech','c.photo','c.capacite','c.prixjournalier','count(h.id) as numberheberge')
        ->join('h.numchambre','c')
            ->groupBy('h.numchambre')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByRecette_1()
    {
        return $this->createQueryBuilder('h')
        ->select('sum(h.montant) as montant','count(h.id) as numberheberge')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByRecetteok($date1a,$date2a)
    {
        return $this->createQueryBuilder('h')
            ->select('sum(h.montant) as montant','c.codech','c.photo','c.capacite','c.prixjournalier','count(h.id) as numberheberge')
            ->join('h.numchambre','c')
            ->where('h.dateentre between :date1 and :date2')
            ->groupBy('h.numchambre')
            ->setParameters(
                array(
                    'date1'=>$date1a,
                    'date2'=>$date2a
                )
            )
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByRecetteok_1($date1a,$date2a)
    {
        return $this->createQueryBuilder('h')
            ->select('sum(h.montant) as montant','count(h.id) as numberheberge')
            ->where('h.dateentre between :date1 and :date2')
            ->setParameters(
                array(
                    'date1'=>$date1a,
                    'date2'=>$date2a
                )
            )
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByStatut($date1a,$statut)
    {
        return $this->createQueryBuilder('h')
            ->select('count(h.id) as nombre')
            ->where('h.datesortie < :date1')
            ->andWhere('h.statut = :date2')
            ->setParameters(
                array(
                    'date1'=>$date1a,
                    'date2'=>$statut, 
                    )
            )
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByStatutlist($date1a,$statut)
    {
        return $this->createQueryBuilder('h')
            ->select('h.id','c.id','c.codech','h.dateentre','h.datesortie','c.statut','c.photo','c.capacite')
            ->join('h.numchambre','c')
            ->where('h.datesortie < :date1')
            ->andWhere('h.statut = :date2')
            ->setParameters(
                array(
                    'date1'=>$date1a,
                    'date2'=>$statut, 
                    )
            )
            ->getQuery()
            ->getResult()
        ;
    }
    public function editFacture($id)
    {
        return $this->createQueryBuilder('h')
            ->select('h.id','h.montant','h.nbjours','h.payement','h.dateentre','h.datesortie','c.codech','c.prixjournalier','s.nom','s.prenom','s.adresse','s.national')
            ->join('h.numchambre','c')
            ->join('h.numcli','s')
            ->where('h.id = :date1')
            ->setParameters(
                array(
                    'date1'=>$id,
                    )
            )
            ->getQuery()
            ->getResult()
        ;
    }

    public function listeheberge($date1a,$statut)
    {
        return $this->createQueryBuilder('h')
            ->select('h.montant','h.nbjours','h.dateentre','h.datesortie','c.codech','c.prixjournalier','c.photo','s.nom','s.prenom','s.adresse','s.national','s.telephone','h.payement')
            ->join('h.numchambre','c')
            ->join('h.numcli','s')            
            ->where('h.dateentre between :date1 and :date2')
            ->groupBy('h.id')
            ->setParameters(
                array(
                    'date1'=>$date1a,
                    'date2'=>$statut, 
                    )
            )
            ->getQuery()
            ->getResult()
        ;
    }

    public function listeheberge_1($date1a,$date2a)
    {
        return $this->createQueryBuilder('h')
            ->select('sum(h.montant) as montant','count(h.id) as numberheberge')
            ->where('h.dateentre between :date1 and :date2')
            ->setParameters(
                array(
                    'date1'=>$date1a,
                    'date2'=>$date2a
                )
            )
            ->getQuery()
            ->getResult()
        ;
    }   
    public function findByHeberge()
    {
        return $this->createQueryBuilder('h')
        ->select('h.montant','h.nbjours','h.dateentre','h.datesortie','c.codech','c.prixjournalier','c.photo','s.nom','s.prenom','s.adresse','s.national','s.telephone','h.payement')
        ->join('h.numchambre','c')
        ->join('h.numcli','s')
        ->groupBy('h.id')
        ->getQuery()
        ->getResult()
        ;
    }
    public function findByHeberge_1()
    {
        return $this->createQueryBuilder('h')
        ->select('sum(h.montant) as montant','count(h.id) as numberheberge')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByHeberge_2()
    {
        return $this->createQueryBuilder('h')
        ->select('s.national','count(s.national) as numbernational')
        ->join('h.numcli','s')
        ->groupBy('s.national')
        ->getQuery()
        ->getResult()
        ;
    }
    public function findByHeberge_3($date1a,$date2a)
    {
        return $this->createQueryBuilder('h')
        ->select('s.national','count(s.national) as numbernational')
        ->where('h.dateentre between :date1 and :date2')
        ->join('h.numcli','s')
        ->groupBy('s.national')
        ->setParameters(
            array(
                'date1'=>$date1a,
                'date2'=>$date2a
            )
        )
        ->getQuery()
        ->getResult()
        ;
    }
    public function findById()
    {
        return $this->createQueryBuilder('h')
        ->select('h.id','c.id as numch','h.nbjours','h.dateentre','h.statut','h.datesortie','c.codech','c.photo','s.nom','s.prenom','h.nbjours','s.telephone')
        ->join('h.numchambre','c')
        ->join('h.numcli','s')
        ->orderBy('h.id', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }
}
