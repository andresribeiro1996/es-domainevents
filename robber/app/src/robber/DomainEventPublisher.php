<?php

namespace App\robber;

use App\robber\application\EventForwardingService;
use App\robber\domain\DomainEvent;
use App\robber\domain\PublishedGlobalEvent;
use App\robber\infrastructure\port\message\DomainEventProducerInKafka;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DomainEventPublisher extends EventDispatcher
{
    /**
     * @var DomainEventPublisher
     */
    private static $instance;

    public static function instance(): self {
        if (!isset(self::$instance))
        {
            self::$instance = new DomainEventPublisher();
            self::$instance->addSubscriber(
                new EventForwardingService(
                    new DomainEventProducerInKafka()
                )
            );
        }

        return self::$instance;
    }

    /**
     * @param DomainEvent[] $eventStream
     */
    public function publish(array $eventStream): void {

        foreach ($eventStream as $domainEvent) {
            $this->dispatch($domainEvent, $domainEvent->getName());

            if($domainEvent->isGlobalEvent()) {
                $globalEvent = new PublishedGlobalEvent($domainEvent);
                $this->dispatch($globalEvent, $globalEvent->getName());
            }
        }
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        parent::addSubscriber($subscriber); // TODO: Change the autogenerated stub
    }
}

