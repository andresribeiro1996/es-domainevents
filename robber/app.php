#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

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

$commandLoader = new FactoryCommandLoader([
    DomainEventConsumerInKafka::getDefaultName() => function () { return new DomainEventConsumerInKafka(); },
]);

$application = new Application();
$application->setCommandLoader($commandLoader);
$application->run();