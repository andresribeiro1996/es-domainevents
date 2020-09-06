<?php


namespace App\robber\domain;


class PublishedGlobalEvent extends DomainEvent
{
    public const TYPE = 'event';
    public const NAME = 'PublishedGlobalEvent';

    /**
     * @var array
     */
    protected $data;

    public function __construct(DomainEvent $event)
    {
        parent::__construct(
            self::SCOPE_GLOBAL . $event->getName(),
            $event->getAggregateId(),
            $event->getAggregateName(),
            self::SCOPE_GLOBAL
        );
        $this->data = $event->getData();
    }

    public function getData(): array
    {
        return array_merge(
            parent::getData(),
            $this->data
        );
    }
}