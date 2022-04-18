<?php
/**
 * User service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UserService.
 */
class UserService
{
    /**
     * User repository.
     *
     * @var \App\Repository\UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param \App\Repository\UserRepository $userRepository User repository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Find user by email
     * @param array $credentials
     *
     * @return User
     */
    public function findOneBy(array $credentials): User
    {
        return $this->userRepository->findOneBy($credentials);
    }
}
