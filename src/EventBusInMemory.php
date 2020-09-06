<?php


namespace App;


use Ramsey\Collection\Collection;

class EventBusInMemory extends Collection
{
    private static $instance = null;

    public static function instance(): EventBusInMemory {
        if (self::$instance == null)
        {
            self::$instance = new EventBusInMemory('mixed');
        }

        return self::$instance;
    }
}