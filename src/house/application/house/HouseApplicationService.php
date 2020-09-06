<?php


namespace App\house\application\house;


use App\house\domain\house\command\CreateHouseCommand;
use App\house\domain\house\House;
use App\house\domain\house\HouseRepository;
use App\house\DomainEventPublisher;

class HouseApplicationService
{
    /**
     * @var HouseRepository
     */
    private $houseRepository;

    public function __construct(HouseRepository $houseRepository)
    {
        $this->houseRepository = $houseRepository;
    }

    public function createHouse(CreateHouseCommand $command)
    {
        $house = House::new();
        $domainEvents = $house->processCreate($command);

        DomainEventPublisher::instance()->publish($domainEvents);
        $this->houseRepository->store($domainEvents);
    }
}