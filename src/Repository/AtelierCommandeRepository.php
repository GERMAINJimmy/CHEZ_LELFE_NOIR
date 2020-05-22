<?php

namespace App\Repository;

use App\Entity\AtelierCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AtelierCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method AtelierCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method AtelierCommande[]    findAll()
 * @method AtelierCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtelierCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AtelierCommande::class);
    }

    // /**
    //  * @return AtelierCommande[] Returns an array of AtelierCommande objects
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
    public function findOneBySomeField($value): ?AtelierCommande
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
