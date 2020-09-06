<?php
namespace App\robber\domain\robber;

use App\robber\domain\AggregateRoot;
use App\robber\domain\DomainEvent;
use App\robber\domain\robber\command\AssaultHouseCommand;
use App\robber\domain\robber\command\CreateRobberCommand;
use App\robber\domain\robber\event\publish\AssaultedHouseEvent;
use App\robber\domain\robber\event\publish\RobberCreatedEvent;

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

    public static function new(): Robber {
        return new self();
    }

    public function getId(): RobberId
    {
        return $this->robberId;
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
                $this->level, $command->getHouseId(),
                DomainEvent::SCOPE_GLOBAL
            )
        ];
    }

    public function processCreateRobber(CreateRobberCommand $command): array
    {
        return [new RobberCreatedEvent($command->getId(), $command->getLevel(), $command->getName())];
    }

    public function applyAssaultedHouseEvent(AssaultedHouseEvent $event)
    {
        $this->increaseLevel();
        $this->addAssaultedHouse($event->getHouseId());
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
}

