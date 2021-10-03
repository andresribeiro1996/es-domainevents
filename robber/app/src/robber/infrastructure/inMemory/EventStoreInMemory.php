<?php

namespace App\robber\infrastructure\inMemory;


use App\robber\domain\AggregateRootId;
use App\robber\domain\DomainEvent;
use App\robber\domain\robber\Robber;
use App\robber\domain\robber\RobberId;
use App\robber\domain\robber\RobberRepository;

class EventStoreInMemory implements RobberRepository
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

    public function getRobber(RobberId $id): Robber
    {
        $robberEventStream = $this->loadEventStream($id);
        $robber = Robber::new();
        $robber->apply($robberEventStream);

        return $robber;
    }
}