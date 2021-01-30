<?php

namespace App\house\infrastructure\inMemory;


use App\house\domain\AggregateRootId;
use App\house\domain\DomainEvent;
use App\house\domain\house\HouseRepository;

class EventStoreInMemory implements HouseRepository
{
    /**
     * @var DomainEvent[]
     */
    private $eventStream;

    /**
     * @param DomainEvent[] $newEvents
     * @return mixed|void
     */
    public function store(array $newEvents)
    {
        // Initialize
        if(!$this->eventStream) {
            $this->eventStream = [];
        }

        $this->eventStream = array_merge($this->eventStream, $newEvents);
    }

    /**
     * @param AggregateRootId $id
     * @return DomainEvent[]
     */
    public function loadEventStream(AggregateRootId $id)
    {
        $aggregateEvents = [];
        foreach ($this->eventStream as $event) {
            if($event->getAggregateId() === $id->id()) {
                $aggregateEvents[] = $event;
            }
        }

        return $aggregateEvents;
    }
}