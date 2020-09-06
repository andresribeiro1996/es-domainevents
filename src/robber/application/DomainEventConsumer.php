<?php


namespace App\robber\application;


interface DomainEventConsumer
{
    public function consume();
}