<?php


namespace App\house\infrastructure\inMemory;


use App\EventBusInMemory;
use App\EventBusInMemoryDispatcher;
use App\house\application\DomainEventProducer;
use App\house\domain\DomainEvent;

class DomainEventProducerInMemory implements DomainEventProducer
{
    private $eventBus;

    /**
     * DomainEventProducerInMemory constructor.
     * @param $eventBus
     */
    public function __construct(EventBusInMemory $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function produce(DomainEvent $domainEvent)
    {
        $this->eventBus->add($domainEvent->getData());
        EventBusInMemoryDispatcher::instance()->poke();
    }
}