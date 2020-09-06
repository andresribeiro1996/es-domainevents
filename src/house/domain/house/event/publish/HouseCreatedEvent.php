<?php


namespace App\house\domain\house\event\publish;


use App\house\domain\DomainEvent;
use App\house\domain\house\Address;
use App\house\domain\house\Alarm;
use App\house\domain\house\HouseId;
use App\house\domain\Money;

class HouseCreatedEvent extends DomainEvent
{
    public const TYPE = 'house';
    public const NAME = 'housecreatedevent';

    /**
     * @var RobberId
     */
    private $houseId;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var Alarm
     */
    private $alarm;

    /**
     * @var Money
     */
    private $money;

    /**
     * CreateHouseCommand constructor.
     * @param HouseId $houseId
     * @param Address $address
     * @param Alarm $alarm
     * @param Money $money
     */
    public function __construct(
        HouseId $houseId,
        Address $address,
        Alarm $alarm,
        Money $money
    )
    {
        $this->houseId = $houseId;
        $this->address = $address;
        $this->alarm = $alarm;
        $this->money = $money;

        parent::__construct(self::NAME, $houseId->id(), self::TYPE, self::SCOPE_LOCAL);
    }



    public function getData(): array
    {
        return array_merge(parent::getData(), [
            'house_id' => $this->houseId->id(),
            'street_name' => $this->address->getStreetName(),
            'postal_code' => $this->address->getPostalCode(),
            'alarm_name' => $this->alarm->getName(),
            'alarm_start_hour' => $this->alarm->getActivePeriod()->getStartHour(),
            'alarm_end_hour' => $this->alarm->getActivePeriod()->getEndHour(),
            'money' => $this->money->getAmount()
        ]);
    }


    public function getHouseId(): HouseId
    {
        return $this->houseId;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return Alarm
     */
    public function getAlarm(): Alarm
    {
        return $this->alarm;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }




}