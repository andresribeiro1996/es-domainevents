<?php


namespace App\house\application;


use App\house\domain\DomainEvent;

interface DomainEventProducer
{
    function produce(DomainEvent $domainEvent);
}