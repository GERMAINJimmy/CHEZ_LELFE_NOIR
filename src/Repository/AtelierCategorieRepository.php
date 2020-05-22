<?php

namespace App\Repository;

use App\Entity\AtelierCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AtelierCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method AtelierCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method AtelierCategorie[]    findAll()
 * @method AtelierCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtelierCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AtelierCategorie::class);
    }
    // /**
    //  * @return AtelierCategorie[] Returns an array of AtelierCategorie objects
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
    public function findOneBySomeField($value): ?AtelierCategorie
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
