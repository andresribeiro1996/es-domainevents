<?php


namespace App\robber\persistence\inMemory;

use App\EventBusInMemory;
use App\house\DomainEventPublisher;
use App\robber\domain\DomainEventFactory;
use App\robber\application\DomainEventConsumer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DomainEventConsumerInMemory implements DomainEventConsumer, EventSubscriberInterface
{
    private $eventBus;

    /**
     * DomainEventConsumerInMemory constructor.
     * @param EventBusInMemory $eventBus
     */
    public function __construct(EventBusInMemory $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public static function getSubscribedEvents()
    {
        return [
            'poke' => 'consume',
        ];
    }

    public function consume()
    {
        foreach ($this->eventBus as $event) {
            DomainEventPublisher::instance()->publish([
                DomainEventFactory::new($event)
            ]);
        }
    }
}