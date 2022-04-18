<?php

namespace App\Repository;

use App\Entity\Odznaka;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Odznaka|null find($id, $lockMode = null, $lockVersion = null)
 * @method Odznaka|null findOneBy(array $criteria, array $orderBy = null)
 * @method Odznaka[]    findAll()
 * @method Odznaka[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OdznakaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Odznaka::class);
    }

    // /**
    //  * @return Odznaka[] Returns an array of Odznaka objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Odznaka
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
