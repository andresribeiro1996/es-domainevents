<?php
namespace App\house\infrastructure;
/**
 * @template T
 * @template TID
 * Interface WriteRepository
 */
interface WriteRepository
{
    /**
     * @psalm-param TID $id
     * @psalm-return T|null
     * @param $id
     */
    public function find($id);

    /**
     * @psalm-param T $aggregate
     * @param $aggregate
     */
    public function save($aggregate): void;
}