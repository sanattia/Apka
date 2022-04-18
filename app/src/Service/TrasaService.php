<?php
/**
 * Trasa service.
 */

namespace App\Service;

use App\Entity\Trasa;
use App\Repository\TrasaRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class TrasaService.
 */
class TrasaService
{
    /**
     * Trasa repository.
     *
     * @var \App\Repository\TrasaRepository
     */
    private TrasaRepository $trasaRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private PaginatorInterface $paginator;

    /**
     * TrasaService constructor.
     *
     * @param \App\Repository\TrasaRepository          $trasaRepository Trasa repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator      Paginator
     */
    public function __construct(TrasaRepository $trasaRepository, PaginatorInterface $paginator)
    {
        $this->trasaRepository = $trasaRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->trasaRepository->queryAll(),
            $page,
            TrasaRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save trasa.
     *
     * @param \App\Entity\Trasa $trasa Trasa entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Trasa $trasa): void
    {
        $this->trasaRepository->save($trasa);
    }

    /**
     * Delete trasa.
     *
     * @param \App\Entity\Trasa $trasa Trasa entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Trasa $trasa): void
    {
        $this->trasaRepository->delete($trasa);
    }

    /**
     * Find trasa by Id.
     *
     * @param int $id Trasa Id
     *
     * @return \App\Entity\Trasa|null Trasa entity
     */
    public function findOneById(int $id): ?Trasa
    {
        return $this->trasaRepository->findOneById($id);
    }

    /**
     * Find trasa by region
     * @param array $region
     *
     * @return Trasa[]
     */
    public function findBy(array $region): array
    {
        return $this->trasaRepository->findBy($region);
    }

    /**
     * Find trasa by trudnosc
     * @param array $trudnosc
     *
     * @return Trasa[]
     */
    public function findTrudnoscBy(array $trudnosc): array
    {
        return $this->trasaRepository->findBy($trudnosc);
    }
}
