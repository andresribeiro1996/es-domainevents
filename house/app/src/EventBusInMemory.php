<?php


namespace App;


use Ramsey\Collection\Collection;

class EventBusInMemory extends Collection
{
    /**
     * @var ?EventBusInMemory
     */
    private static $instance;

    public static function instance(): EventBusInMemory {
        if (self::$instance == null)
        {
            self::$instance = new EventBusInMemory('mixed');
        }

        return self::$instance;
    }
}