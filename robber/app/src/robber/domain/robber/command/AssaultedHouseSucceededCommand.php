<?php


namespace App\robber\domain\robber\command;


class AssaultedHouseSucceededCommand
{
    /**
     * @var int
     */
    private $robberId;

    /**
     * @var int
     */
    private $houseId;

    /**
     * @var int
     */
    private $houseMoney;

    /**
     * @var int
     */
    private $robberLevel;

    /**
     * AssaultHouseCommand constructor.
     * @param int $robberId
     * @param int $houseId
     * @param int $houseMoney
     * @param int $robberLevel
     */
    public function __construct(int $robberId, int $houseId, int $houseMoney, int $robberLevel)
    {
        $this->robberId = $robberId;
        $this->houseId = $houseId;
        $this->houseMoney = $houseMoney;
        $this->robberLevel = $robberLevel;
    }

    public function getRobberId(): int
    {
        return $this->robberId;
    }

    public function getHouseId(): int
    {
        return $this->houseId;
    }

    public function getHouseMoney(): int
    {
        return $this->houseMoney;
    }

    public function getRobberLevel(): int {
        return $this->robberLevel;
    }
}