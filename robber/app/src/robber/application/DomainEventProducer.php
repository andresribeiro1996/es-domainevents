<?php


namespace App\robber\application;

use App\robber\domain\DomainEvent;

interface DomainEventProducer
{
    function produce(DomainEvent $domainEvent);
}