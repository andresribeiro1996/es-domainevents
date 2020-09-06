<?php


namespace App\house\domain;

interface EventStore
{
    /**
     * @param DomainEvent[] $event
     * @return mixed
     */
    public function store(array $event);

    /**
     * @param AggregateRootId $id
     * @return DomainEvent[]
     */
    public function loadEventStream(AggregateRootId $id);
}