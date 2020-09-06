<?php


namespace App\robber\domain;

interface EventStore
{
    /**
     * @param DomainEvent[] $event
     */
    public function store(array $event);

    /**
     * @param AggregateRootId $id
     * @return DomainEvent[]
     */
    public function loadEventStream(AggregateRootId $id);
}