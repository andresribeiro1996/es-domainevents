<?php


namespace App\house\application;


interface DomainEventConsumer
{
    public function consume();
}