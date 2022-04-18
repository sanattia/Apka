<?php

namespace App\Repository;

use App\Entity\Trasa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trasa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trasa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trasa[]    findAll()
 * @method Trasa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrasaRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * TrasaRepository constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trasa::class);
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial trasa.{id, createdAt, updatedAt, name, czas, points, punktStartowy, punktKoncowy}',
                'partial trudnosc.{id, name}',
                'partial region.{id, name}'
            )
            ->join('trasa.trudnosc', 'trudnosc')
            ->leftJoin('trasa.region', 'region')
            ->orderBy('trasa.updatedAt', 'DESC');
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Trasa $trasa Trasa entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Trasa $trasa): void
    {
        $this->_em->persist($trasa);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Trasa $trasa Trasa entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Trasa $trasa): void
    {
        $this->_em->remove($trasa);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('trasa');
    }
}
