<?php


namespace App\house\domain\house\event\publish;


use App\house\domain\DomainEvent;

class AssaultedHouseSucceededEvent extends DomainEvent
{
    public const TYPE = 'robber';
    public const NAME = 'assaultedhousesucceededevent';

    /**
     * @var int
     */
    protected $houseMoney;

    /**
     * @var int
     */
    protected $robberId;

    /**
     * @var int
     */
    protected $robberLevel;

    public function __construct(int $robberId, int $robberLevel, int $houseMoney)
    {
        $this->houseMoney = $houseMoney;
        $this->robberId = $robberId;
        $this->robberLevel = $robberLevel;

        parent::__construct(self::NAME, $robberId, self::TYPE, self::SCOPE_LOCAL);
    }

    public function getData(): array
    {
        return array_merge(
            parent::getData(),
            [
                'robber_id' => $this->robberId,
                'house_money' => $this->houseMoney,
                'robber_level' => $this->robberLevel
            ]
        );
    }

    public function getRobberId(): int
    {
        return $this->robberId;
    }

    public function getHouseMoney(): int
    {
        return $this->houseMoney;
    }

    public function getRobberLevel(): int
    {
        return $this->robberLevel;
    }
}