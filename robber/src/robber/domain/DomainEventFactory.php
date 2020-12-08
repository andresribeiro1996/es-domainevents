<?php

namespace App\robber\domain;


class DomainEventFactory
{
    public static function new(array $eventData): DomainEvent
    {
        $eventName = $eventData['event_name'];
        switch ($eventName) {
            default: throw new \Exception('Domain event not found in factory');
        }
    }
}