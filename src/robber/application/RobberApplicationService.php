<?php

namespace App\robber\application;

use App\robber\domain\robber\command\AssaultHouseCommand;
use App\robber\domain\robber\command\CreateRobberCommand;
use App\robber\domain\robber\Robber;
use App\robber\domain\robber\RobberId;
use App\robber\domain\robber\RobberRepository;
use App\robber\DomainEventPublisher;

class RobberApplicationService
{
    /**
     * @var RobberRepository
     */
    private $robberRepository;

    /**
     * RobberApplicationService constructor.
     * @param $robberRepository
     */
    public function __construct(RobberRepository $robberRepository)
    {
        $this->robberRepository = $robberRepository;
    }

    public function assaultHouseOfId(int $robberId, int $houseId)
    {
        $oldEvents = $this->robberRepository->loadEventStream(new RobberId($robberId));
        $robber = Robber::new();
        $robber->apply($oldEvents);

        $domainEvents = $robber->processAssault(new AssaultHouseCommand($robberId, $houseId, $robber->getLevel()));

        DomainEventPublisher::instance()->publish($domainEvents);
        $this->robberRepository->store($domainEvents);
    }

    public function createRobber(int $robberId, string $name, int $level)
    {
        $robber = Robber::new();
        $domainEvents = $robber->processCreateRobber(new CreateRobberCommand($robberId, $name, $level));

        DomainEventPublisher::instance()->publish($domainEvents);
        $this->robberRepository->store($domainEvents);
    }
}