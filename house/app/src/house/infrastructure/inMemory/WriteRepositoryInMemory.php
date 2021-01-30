<?php
namespace App\house\infrastructure\inMemory;

use App\house\domain\AggregateRoot;
use App\house\infrastructure\Loader;
use App\house\infrastructure\WriteRepository;

/**
 * @implements WriteRepository<T, TID>
 * @template T
 * @template TID
 */
class WriteRepositoryInMemory implements WriteRepository
{
    /**
     * @psalm-var array<int, T>
     * @psalm-var
     */
    private $collection;

    /**
     * @psalm-param Loader<T> $bootstrap
     * @param Loader $bootstrap
     */
    public function __construct(Loader $bootstrap)
    {
        $this->collection = $bootstrap->load();
    }

    /**
     * @psalm-param TID $id
     * @psalm-return T
     * @param $id
     * @return mixed | null
     */
    public function find($id)
    {
        foreach ($this->collection as $aggregate) {
            if($aggregate->getId()->equals($id) ) {
                return $aggregate;
            };
        }

        return null;
    }

    /**
     * @psalm-param T $aggregate
     * @param AggregateRoot $aggregate
     */
    public function save($aggregate): void
    {
    }
}