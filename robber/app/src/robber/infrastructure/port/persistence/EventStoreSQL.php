<?php


use App\robber\domain\EventStore;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class EventStoreSQL implements EventStore
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function store(array $event)
    {
    }

    public function loadEventStream(\App\robber\domain\AggregateRootId $id)
    {
        // TODO: Implement loadEventStream() method.
    }

    public function getRobber(\App\robber\domain\robber\RobberId $id): \App\robber\domain\robber\Robber
    {
        // TODO: Implement getRobber() method.
    }
}