<?php


use App\house\application\house\HouseApplicationService;
use App\house\application\house\HouseSubscriber;
use App\house\domain\house\command\CreateHouseCommand;
use App\house\domain\house\House;
use App\house\domain\house\HouseId;
use App\house\DomainEventPublisher;
use App\house\infrastructure\inMemory\HouseRepositoryInMemory;
use App\robber\application\RobberApplicationService;
use App\robber\infrastructure\inMemory\RobberRepositoryInMemory;
use PHPUnit\Framework\TestCase;

class TheGreatAssaultTest extends TestCase
{

    private $robberService;

    private $houseService;

    private $houseRepository;

    private $robberRepository;

    private $houseSubscriber;

    protected function setUp(): void
    {

        // Robber Bounded Context
        $this->robberRepository = new RobberRepositoryInMemory();
        $this->robberService = new RobberApplicationService($this->robberRepository);

        parent::setUp();
    }

    public function testApp()
    {
        $this->houseService->createHouse(
            new CreateHouseCommand(
            1,
            'rua1',
            '1111',
            'day alarm',
            8,
            8,
            1000
        ));

        $this->robberService->createRobber(1,'andre', 1);
        $this->robberService->createRobber(1,'andre', 1);
        $this->robberService->createRobber(2,'tiago', 2);

        $this->robberService->assaultHouseOfId(1, 1);

        $houseEventStream = $this->houseRepository->loadEventStream(new HouseId(1));
        $house = House::new();
        $house->apply($houseEventStream);
    }
}
