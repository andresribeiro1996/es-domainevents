<?php


namespace App\robber\domain\robber\event\subscribe;


use App\robber\domain\DomainEvent;

class AssaultedHouseSucceededEvent extends DomainEvent
{
    public const TYPE = 'robber';
    public const NAME = 'assaultedhousesucceededevent';

    /**
     * @var int
     */
    protected $robberId;

    /**
     * @var int
     */
    protected $houseId;

    /**
     * @var int
     */
    protected $robberLevel;

    /**
     * @var int
     */
    protected $houseMoney;

    public function __construct(int $robberId, int $houseId, int $robberLevel, int $houseMoney)
    {
        $this->houseMoney = $houseMoney;
        $this->robberId = $robberId;
        $this->robberLevel = $robberLevel;
        $this->houseId = $houseId;

        parent::__construct(self::NAME, $robberId, self::TYPE, self::SCOPE_LOCAL);
    }

    public function getData(): array
    {
        return array_merge(
            parent::getData(),
            [
                'robber_id' => $this->robberId,
                'house_id' => $this->houseId,
                'house_money' => $this->houseMoney,
                'robber_level' => $this->robberLevel,
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

    public function getHouseId():int
    {
        return $this->houseId;
    }
}