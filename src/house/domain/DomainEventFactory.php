<?php


namespace App\house\domain;


use App\house\domain\house\event\subscribe\AssaultedHouseEvent;

class DomainEventFactory
{
    public static function new(array $eventData): DomainEvent
    {
        $eventName = $eventData['event_name'];
        switch ($eventName) {
            case 'assaultedhouseevent' :
                return new AssaultedHouseEvent(
                    $eventData['robber_id'],
                    $eventData['robber_level'],
                    $eventData['house_id']
                );

            default: throw new \Exception('Domain event not found in factory');
        }
    }
}