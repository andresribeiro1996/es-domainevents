<?php

namespace App\house\domain\house;

use App\house\domain\AggregateRoot;
use App\house\domain\DomainEvent;
use App\house\domain\house\command\CreateHouseCommand;
use App\house\domain\house\event\publish\AssaultedHouseFailedEvent;
use App\house\domain\house\event\publish\AssaultedHouseSucceededEvent;
use App\house\domain\house\event\publish\HouseCreatedEvent;
use App\house\domain\house\event\subscribe\AssaultedHouseEvent;
use App\house\domain\Money;

/**
 * @extends AggregateRoot<House, HouseId>
 */
class House extends AggregateRoot {
    /**
     * @var HouseId
     */
    private $houseId;

    /**
     * @var Alarm
     */
    private $alarm;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var Money
     */
    private $money;

    /**
     * @var array<int,int>
     */
    private $robbers;


    public static function new(): House
    {
        return new self();
    }

    /**
     * @return Alarm
     */
    public function getAlarm(): Alarm
    {
        return $this->alarm;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return Money
     */
    public function getMoney(): Money
    {
        return $this->money;
    }

    /**
     * @param CreateHouseCommand $command
     * @return DomainEvent[]
     */
    public function processCreate(CreateHouseCommand $command): array {
        return [
            new HouseCreatedEvent(
                new HouseId($command->getHouseId()),
                new Address($command->getStreetName(), $command->getPostalCode()),
                new Alarm(
                    $command->getAlarmName(),
                    new ActivePeriod($command->getAlarmStartHour(), $command->getAlarmEndHour())),
                new Money($command->getMoney())
            )
        ];
    }

    public function applyHouseCreatedEvent(HouseCreatedEvent $event): void
    {
        $this->houseId = $event->getHouseId();
        $this->address = $event->getAddress();
        $this->alarm = $event->getAlarm();
        $this->money = $event->getMoney();
    }

    /**
     * @param int $robberId
     * @param int $level
     * @return DomainEvent[]
     */
    public function processAssault(int $robberId, int $level): array
    {
        if($this->money > 1500) {
            return [new AssaultedHouseFailedEvent($robberId)];
        }

        return [new AssaultedHouseSucceededEvent($robberId, $level, $this->money->getAmount())];
    }

    public function applyAssaultedHouseSucceededEvent(AssaultedHouseSucceededEvent $event): void
    {
        $percentageToRob = $event->getRobberLevel() * 10;
        $amount = $this->money->getAmount();
        $this->money = new Money((int)($amount - ($amount * ($percentageToRob/100))));
        $this->robbers[] = $event->getRobberId();
    }


    public function getId(): HouseId
    {
        return $this->houseId;
    }
}

