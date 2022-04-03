<?php

namespace App\robber\application\robber;

use App\robber\domain\robber\command\AssaultedHouseSucceededCommand;
use App\robber\domain\robber\event\subscribe\AssaultedHouseSucceededEvent;
use App\robber\domain\robber\RobberId;
use App\robber\domain\robber\RobberRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RobberSubscriber implements EventSubscriberInterface
{
    /**
     * @var RobberRepository
     */
    private $robberRepository;

    public function __construct(RobberRepository $robberRepository)
    {
        $this->robberRepository = $robberRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            AssaultedHouseSucceededEvent::NAME => 'onSucceededAssault',
        ];
    }

    /**
     * This approach allow us to implement logic in the processAssaultedHouse method
     * in this method we can decide what happens if the assault succeeded, for eg:
     * - if the money stolen is above X then the police should be warned.
     *
     * In the simpler method below we cant do that, i mean, we can but it will not be encapsulated and the logic will be
     * spread around the code.
     * And we should use the 'processMethods' to decide what happens when actions occur in our domain.
     *
     * This approach may sound redundant because this is a simple scenario
     */
    public function onSucceededAssault(AssaultedHouseSucceededEvent $event): void
    {
        $robber = $this->robberRepository->getRobber(new RobberId($event->getRobberId()));

        $resultedEvents = $robber->processAssaultedHouseSucceededEvent(new AssaultedHouseSucceededCommand(
            $event->getRobberId(),
            $event->getHouseId(),
            $event->getHouseMoney(),
            $event->getRobberLevel()
        ));

        $this->robberRepository->store($resultedEvents);
    }

    /**
     * Simpler solution, but not as complete as the above
     *
     */
//    public function onSucceededAssault(AssaultedHouseSucceededEvent $event): void
//    {
//        $robber = $this->robberRepository->getRobber(new RobberId($event->getRobberId()));
//
//        $robber->applyAssaultedHouseSucceededEvent($event);
//        $newEventStream = [$event];
//
//        $this->robberRepository->store($newEventStream);
//    }
}