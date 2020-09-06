<?php


namespace App\house\application;

use App\house\domain\DomainEvent;
use App\house\domain\house\event\subscribe\AssaultedHouseEvent;
use App\house\domain\PublishedGlobalEvent;
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

    public function onPublishedGlobalEvent(DomainEvent $event)
    {
        $this->globalDomainEventProducer->produce($event);
    }

}