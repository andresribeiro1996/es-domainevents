<?php


namespace App\house\domain\house\command;


class CreateHouseCommand
{
    /**
     * @var int
     */
    private $houseId;
    /**
     * @var string
     */
    private $streetName;
    /**
     * @var string
     */
    private $postalCode;
    /**
     * @var string
     */
    private $alarmName;
    /**
     * @var int
     */
    private $alarmStartHour;
    /**
     * @var int
     */
    private $alarmEndHour;
    /**
     * @var int
     */
    private $money;

    /**
     * CreateHouseCommand constructor.
     * @param int $houseId
     * @param string $streetName
     * @param string $postalCode
     * @param string $alarmName
     * @param int $alarmStartHour
     * @param int $alarmEndHour
     * @param int $money
     */
    public function __construct(
        int $houseId,
        string $streetName,
        string $postalCode,
        string $alarmName,
        int $alarmStartHour,
        int $alarmEndHour,
        int $money
    )
    {
        $this->houseId = $houseId;
        $this->streetName = $streetName;
        $this->postalCode = $postalCode;
        $this->alarmName = $alarmName;
        $this->alarmStartHour = $alarmStartHour;
        $this->alarmEndHour = $alarmEndHour;
        $this->money = $money;
    }

    /**
     * @return int
     */
    public function getHouseId(): int
    {
        return $this->houseId;
    }

    /**
     * @return string
     */
    public function getStreetName(): string
    {
        return $this->streetName;
    }

    /**
     * @return string
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function getAlarmName(): string
    {
        return $this->alarmName;
    }

    /**
     * @return int
     */
    public function getAlarmStartHour(): int
    {
        return $this->alarmStartHour;
    }

    /**
     * @return int
     */
    public function getAlarmEndHour(): int
    {
        return $this->alarmEndHour;
    }

    /**
     * @return int
     */
    public function getMoney(): int
    {
        return $this->money;
    }


}