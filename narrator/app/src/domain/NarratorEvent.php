<?php

namespace Narrator\domain;

class NarratorEvent
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $aggregateId;
    /**
     * @var string
     */
    private $aggregateName;
    /**
     * @var array
     */
    private $data;

    public function __construct(string $name, int $aggregateId, string $aggregateName, array $data)
    {

        $this->name = $name;
        $this->aggregateId = $aggregateId;
        $this->aggregateName = $aggregateName;
        $this->data = $data;
    }

    public function toArray(): array {
        return [
            'event_name' => $this->name,
            'aggregate_name' => $this->aggregateName,
            'aggregate_id' => $this->aggregateName,
            'data' => $this->data
        ];
    }
}