<?php

namespace App\Repository;

use App\Entity\Promotion;
use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function getProduit($value): ?Promotion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findAllPromotion()
    {
        $manager = $this->getEntityManager();
        $query = $manager -> createQuery("SELECT p.id,p.titre,p.prix,p.photo,p.slug,MAX(promo.prix) as promoprix,MAX(promo.dateModification) as date_modification FROM App\Entity\Produit p JOIN App\Entity\Promotion promo WITH p.id = promo.produit GROUP BY promo.produit ORDER BY date_modification DESC"); 
        return $query->setMaxResults(3)->getResult();
    }

    public function findPrixPromotion()
    {
        $manager = $this->getEntityManager();
        $query = $manager -> createQuery("SELECT p.id,p.prix,MAX(promo.prix) as promoprix,MAX(promo.dateModification) as date_modification FROM App\Entity\Produit p JOIN App\Entity\Promotion promo WITH p.id = promo.produit GROUP BY promo.produit ORDER BY date_modification DESC"); 
        return $query->getResult();
    }
    
    // public function findAllPromotion2()
    // {
    //     // Pas besoin de from, on est dans Produit lié à la table produit
    //     return $this->createQueryBuilder('promo')
    //                 -> select('p.id','p.titre','p.prix','promo.prix as promoprix')
    //                 -> join('App\Entity\Produit','p')
    //                 -> groupBy('p.id')
    //                 -> getQuery()
    //                 -> getResult();
    // }
    // /**
    //  * @return Promotion[] Returns an array of Promotion objects
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
    public function findOneBySomeField($value): ?Promotion
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
