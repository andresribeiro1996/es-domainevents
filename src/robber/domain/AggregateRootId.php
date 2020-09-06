<?php
namespace App\robber\domain;
/**
 * @template T
 * Class AggregateRoot
 */
class AggregateRootId
{
    /**
     * @psalm-var T
     */
    private $id;

    /**
     * AggregateRoot constructor.
     * @psalm-param T $id
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @psalm-return T
     */
    public function id()
    {
        return $this->id;
    }

    public function equals(AggregateRootId $otherId) {
        return $otherId->id() === $this->id();
    }
}