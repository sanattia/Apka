<?php
/**
 * Record repository.
 */

namespace App\Repository;

/**
 * Class RecordRepository.
 */
class RecordRepository
{
    /**
     * Data.
     */
    private array $data;

    /**
     * Find all.
     *
     * @return array Result
     */
    public function findAll(): array
    {
        return $this->data;
    }

    /**
     * Find one by Id.
     *
     * @param int $id Id
     *
     * @return array|null Result
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data)
            ? $this->data[$id] : null;
    }
}
