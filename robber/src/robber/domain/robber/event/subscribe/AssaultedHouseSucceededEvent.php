<?php


namespace App\robber\domain\robber\event\subscribe;


use App\robber\domain\DomainEvent;

class AssaultedHouseSucceededEvent extends DomainEvent
{
    public const TYPE = 'robber';
    public const NAME = 'assaultedhousesucceededevent';

    protected $robberId;

    public function __construct(int $robberId)
    {

        $this->robberId = $robberId;

        parent::__construct(self::NAME, $robberId, self::TYPE, self::SCOPE_LOCAL);

    }

    public function getData(): array
    {
        return array_merge(parent::getData(), ['robber_id' => $this->robberId]);
    }

    /**
     * @return int
     */
    public function getRobberId(): int
    {
        return $this->robberId;
    }
}