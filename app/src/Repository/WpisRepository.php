<?php

namespace App\Repository;

use App\Entity\Wpis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wpis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wpis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wpis[]    findAll()
 * @method Wpis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WpisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wpis::class);
    }

    // /**
    //  * @return Wpis[] Returns an array of Wpis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wpis
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
