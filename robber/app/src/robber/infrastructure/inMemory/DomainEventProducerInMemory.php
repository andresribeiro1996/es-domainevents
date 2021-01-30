<?php


namespace App\robber\infrastructure\inMemory;

use App\EventBusInMemory;
use App\EventBusInMemoryDispatcher;
use App\robber\application\DomainEventProducer;
use App\robber\domain\DomainEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

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