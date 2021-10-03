<?php


namespace App\robber\domain;

use App\robber\domain\robber\Robber;
use App\robber\domain\robber\RobberId;

interface EventStore
{
    /**
     * @param DomainEvent[] $event
     */
    public function store(array $event);

    /**
     * @param AggregateRootId $id
     * @return DomainEvent[]
     *
     */
    public function loadEventStream(AggregateRootId $id);

    public function getRobber(RobberId $id): Robber;
}