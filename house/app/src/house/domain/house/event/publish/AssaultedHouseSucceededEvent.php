<?php


namespace App\house\domain\house\event\publish;


use App\house\domain\DomainEvent;

class AssaultedHouseSucceededEvent extends DomainEvent
{
    public const TYPE = 'house';
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

    /**
     * @var int
     */
    protected $houseId;

    public function __construct(int $robberId, int $houseId, int $robberLevel, int $houseMoney)
    {
        $this->houseMoney = $houseMoney;
        $this->robberId = $robberId;
        $this->robberLevel = $robberLevel;
        $this->houseId = $houseId;

        parent::__construct(self::NAME, $houseId, self::TYPE, self::SCOPE_GLOBAL);
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