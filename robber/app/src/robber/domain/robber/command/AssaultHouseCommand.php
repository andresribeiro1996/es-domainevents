<?php


namespace App\robber\domain\robber\command;


class AssaultHouseCommand
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
    private $robberLevel;

    /**
     * AssaultHouseCommand constructor.
     * @param $robberId
     * @param $houseId
     * @param $robberLevel
     */
    public function __construct(int $robberId, int $houseId, int $robberLevel)
    {
        $this->robberId = $robberId;
        $this->houseId = $houseId;
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

    public function getRobberLevel(): int
    {
        return $this->robberLevel;
    }

}