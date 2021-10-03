<?php

namespace App\robber\application;

use App\robber\domain\DomainEvent;
use App\robber\domain\PublishedGlobalEvent;
use App\robber\domain\robber\event\publish\AssaultedHouseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventForwardingService implements EventSubscriberInterface
{
    /**
     * @var DomainEventProducer
     */
    private $globalDomainEventProducer;

    public function __construct(DomainEventProducer $globalDomainEventProducer)
    {
        $this->globalDomainEventProducer = $globalDomainEventProducer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DomainEvent::SCOPE_GLOBAL . AssaultedHouseEvent::NAME => 'onPublishedGlobalEvent',
        ];
    }

    public function onPublishedGlobalEvent(DomainEvent $event)
    {
        $this->globalDomainEventProducer->produce($event);
    }
}