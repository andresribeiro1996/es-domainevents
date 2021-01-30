<?php

namespace App\robber\domain;


use App\robber\domain\robber\event\subscribe\AssaultedHouseSucceededEvent;

class DomainEventFactory
{
    public static function new(array $eventData): DomainEvent
    {
        $eventName = (string) $eventData['event_name'];
        switch ($eventName) {
            case 'assaultedhousesucceededevent' :
                return new AssaultedHouseSucceededEvent(
                    (int) $eventData['robber_id'],
                    (int) $eventData['house_id'],
                    (int) $eventData['robber_level'],
                    (int) $eventData['house_money']
                );
            default: throw new \Exception('Domain event not found in factory');
        }
    }
}