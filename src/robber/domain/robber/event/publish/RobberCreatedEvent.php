<?php

namespace App\robber\domain\robber\event\publish;

use App\robber\domain\DomainEvent;

class RobberCreatedEvent extends DomainEvent
{
    public const TYPE = 'robber';
    public const NAME = 'robbercreatedevent';

    protected $robberLevel;
    protected $robberId;
    protected $name;

    public function __construct(int $robberId, int $robberLevel, string $name)
    {
        $this->robberLevel = $robberLevel;
        $this->name = $name;
        $this->robberId = $robberId;

        parent::__construct(self::NAME, $robberId, self::TYPE, self::SCOPE_LOCAL);

    }

    public function getRobberLevel(): int
    {
        return $this->robberLevel;
    }

    public function getRobberName(): string
    {
        return $this->name;
    }

    public function getData(): array
    {
        return array_merge(parent::getData(), ['robber_id' => $this->robberId, 'robber_level' => $this->robberLevel, 'robber_name' => $this->name]);
    }

    /**
     * @return int
     */
    public function getRobberId(): int
    {
        return $this->robberId;
    }

}