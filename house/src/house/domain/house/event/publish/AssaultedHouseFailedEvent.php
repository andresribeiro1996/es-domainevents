<?php


namespace App\house\domain\house\event\publish;


use App\house\domain\DomainEvent;

class AssaultedHouseFailedEvent extends DomainEvent
{
    public const TYPE = 'robber';
    public const NAME = 'assaultedhousefailedevent';

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