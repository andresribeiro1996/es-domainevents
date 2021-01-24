#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\house\application\house\HouseApplicationService;
use App\house\application\house\HouseSubscriber;
use App\house\domain\house\command\CreateHouseCommand;
use App\house\DomainEventPublisher;
use App\house\infrastructure\inMemory\HouseRepositoryInMemory;
use App\house\infrastructure\message\DomainEventConsumerInKafka;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;

/*$containerBuilder = new ContainerBuilder();
$containerBuilder->register(DomainEventConsumerInKafka::class);
$containerBuilder->compile();

$commandLoader = new ContainerCommandLoader($containerBuilder, [
    'kafka:events' => DomainEventConsumerInKafka::class,
]);*/

// House Bounded Context
$houseRepository = new HouseRepositoryInMemory();
$houseService = new HouseApplicationService($houseRepository);
$houseSubscriber = new HouseSubscriber($houseRepository);

DomainEventPublisher::instance()->addSubscriber($houseSubscriber);

$houseService->createHouse(
    new CreateHouseCommand(
        1,
        'rua1',
        '1111',
        'day alarm',
        8,
        8,
        1000
    ));

$commandLoader = new FactoryCommandLoader([
    DomainEventConsumerInKafka::getDefaultName() => function () { return new DomainEventConsumerInKafka(); },
]);

$application = new Application();
$application->setCommandLoader($commandLoader);
$application->run();