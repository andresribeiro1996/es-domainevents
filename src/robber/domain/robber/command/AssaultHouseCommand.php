<?php


namespace App\robber\domain\robber\command;


class AssaultHouseCommand
{
    private $robberId;
    private $houseId;
    private $robberLevel;

    /**
     * AssaultHouseCommand constructor.
     * @param $robberId
     * @param $houseId
     * @param $robberLevel
     */
    public function __construct($robberId, $houseId, $robberLevel)
    {
        $this->robberId = $robberId;
        $this->houseId = $houseId;
        $this->robberLevel = $robberLevel;
    }

    /**
     * @return mixed
     */
    public function getRobberId()
    {
        return $this->robberId;
    }

    /**
     * @return mixed
     */
    public function getHouseId()
    {
        return $this->houseId;
    }

    /**
     * @return mixed
     */
    public function getRobberLevel()
    {
        return $this->robberLevel;
    }

}