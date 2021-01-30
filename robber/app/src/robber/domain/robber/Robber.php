<?php
namespace App\robber\domain\robber;

use App\robber\domain\AggregateRoot;
use App\robber\domain\DomainEvent;
use App\robber\domain\robber\command\AssaultedHouseSucceededCommand;
use App\robber\domain\robber\command\AssaultHouseCommand;
use App\robber\domain\robber\command\CreateRobberCommand;
use App\robber\domain\robber\event\publish\AssaultedHouseEvent;
use App\robber\domain\robber\event\publish\RobberCreatedEvent;
use App\robber\domain\robber\event\subscribe\AssaultedHouseSucceededEvent;

/**
 * @extends AggregateRoot<Robber, RobberId>
 */
class Robber extends AggregateRoot
{
    /**
     * @var RobberId
     */
    private $robberId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $level;

    /**
     * @var array<int>
     */
    private $assaultedHouses;

    /**
     * @var int
     */
    private $collectedMoney;

    public function __constructor() {

    }

    public static function new(): Robber {
        return new self();
    }

    public function getId(): RobberId
    {
        return $this->robberId;
    }

    public function getAssaultHouses(): array
    {
        if(!$this->assaultedHouses) {
            return [];
        }
        return $this->assaultedHouses;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    public function increaseLevel()
    {
        $this->level++;
    }

    public function addAssaultedHouse(int $houseId)
    {
        $this->assaultedHouses[] = $houseId;
    }

    /**
     * @param AssaultHouseCommand $command
     * @return DomainEvent[]
     */
    public function processAssault(AssaultHouseCommand $command): array
    {
        return [
            new AssaultedHouseEvent(
                $command->getRobberId(),
                $this->level,
                $command->getHouseId(),
                DomainEvent::SCOPE_GLOBAL
            )
        ];
    }

    /**
     * @param AssaultedHouseSucceededCommand $command
     * @return DomainEvent[]
     */
    public function processAssaultedHouseSucceededEvent(AssaultedHouseSucceededCommand $command): array
    {
        return [
            new AssaultedHouseSucceededEvent(
                $command->getRobberId(),
                $command->getHouseId(),
                $command->getRobberLevel(),
                $command->getHouseMoney()
            )
        ];
    }


    public function processCreateRobber(CreateRobberCommand $command): array
    {
        return [new RobberCreatedEvent($command->getId(), $command->getLevel(), $command->getName())];
    }

    public function applyAssaultedHouseSucceededEvent(AssaultedHouseSucceededEvent $event): void
    {
        $this->increaseLevel();
        $this->addAssaultedHouse($event->getHouseId());
        $this->increaseCollectedMoney($event->getHouseMoney());
    }

    public function applyAssaultedHouseEvent(AssaultedHouseEvent $event): void
    {
    }

    public function applyRobberCreatedEvent(RobberCreatedEvent $event): void
    {
        $this->level = $event->getRobberLevel();
        $this->robberId = new RobberId($event->getAggregateId());
        $this->name = $event->getRobberName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    private function increaseCollectedMoney(int $moneyCollected): int
    {
        $this->collectedMoney += $moneyCollected;
        return $this->collectedMoney;
    }
}

