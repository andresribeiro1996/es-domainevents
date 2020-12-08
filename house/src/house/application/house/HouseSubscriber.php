<?php


namespace App\house\application\house;

use App\house\domain\DomainEvent;
use App\house\domain\house\event\subscribe\AssaultedHouseEvent;
use App\house\domain\house\House;
use App\house\domain\house\HouseId;
use App\house\domain\house\HouseRepository;
use App\house\DomainEventPublisher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HouseSubscriber implements EventSubscriberInterface
{
    /**
     * @var HouseRepository
     */
    private $houseRepository;

    /**
     * HouseSubscriber constructor.
     * @param HouseRepository $houseRepository
     */
    public function __construct(HouseRepository $houseRepository)
    {
        $this->houseRepository = $houseRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            AssaultedHouseEvent::NAME => 'onAssaultedHouse',
        ];
    }

    public function onAssaultedHouse(AssaultedHouseEvent $event): void
    {
        $houseEventStream = $this->houseRepository->loadEventStream(new HouseId($event->getHouseId()));
        $house = House::new();
        $house->apply($houseEventStream);

        $newEventStream = $house->processAssault($event->getRobberId(), $event->getRobberLevel());
        DomainEventPublisher::instance()->publish($newEventStream);

        $this->houseRepository->store($newEventStream);
    }
}