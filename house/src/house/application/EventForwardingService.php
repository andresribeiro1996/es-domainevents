<?php


namespace App\house\application;

use App\house\domain\DomainEvent;
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

    public static function getSubscribedEvents()
    {
        return [];
    }

    public function onPublishedGlobalEvent(DomainEvent $event): void
    {
        $this->globalDomainEventProducer->produce($event);
    }

}