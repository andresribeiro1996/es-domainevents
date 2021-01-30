<?php

namespace App\robber\application\robber;

use App\house\domain\house\event\subscribe\AssaultedHouseEvent;
use App\house\domain\house\House;
use App\house\domain\house\HouseId;
use App\house\domain\house\HouseRepository;
use App\house\DomainEventPublisher;
use App\robber\domain\robber\command\AssaultHouseCommand;
use App\robber\domain\robber\event\subscribe\AssaultedHouseSucceededEvent;
use App\robber\domain\robber\Robber;
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

    public function onSucceededAssault(AssaultedHouseSucceededEvent $event): void
    {
        $robberEventStream = $this->robberRepository->loadEventStream(new RobberId($event->getRobberId()));
        $robber = Robber::new();
        $robber->apply($robberEventStream);

        $robber->applyAssaultedHouseSucceededEvent($event);
        $newEventStream = [$event];

        $this->robberRepository->store($newEventStream);
    }
}