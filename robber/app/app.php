#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use App\house\application\house\HouseSubscriber;
use App\robber\application\console\AssaultHouseCommand;
use App\robber\application\robber\RobberSubscriber;
use App\robber\application\RobberApplicationService;
use App\robber\DomainEventPublisher;
use App\robber\infrastructure\inMemory\RobberRepositoryInMemory;
use App\robber\infrastructure\message\DomainEventConsumerInKafka;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/*$containerBuilder = new ContainerBuilder();
$containerBuilder->register(DomainEventConsumerInKafka::class);
$containerBuilder->compile();

$commandLoader = new ContainerCommandLoader($containerBuilder, [
    'kafka:events' => DomainEventConsumerInKafka::class,
]);*/

// Robber Bounded Context - Dependencies
$robberRepository = new RobberRepositoryInMemory();
$robberService = new RobberApplicationService($robberRepository);
$robberSubscriber = new RobberSubscriber($robberRepository);

DomainEventPublisher::instance()->addSubscriber($robberSubscriber);

$robberService->createRobber(1,'andre', 1);

$commandLoader = new FactoryCommandLoader([
    DomainEventConsumerInKafka::getDefaultName() => function () { return new DomainEventConsumerInKafka(); },
    AssaultHouseCommand::getDefaultName() => function () use ($robberService) { return new AssaultHouseCommand($robberService); }
]);

$application = new Application();
$application->setCommandLoader($commandLoader);
$application->run();