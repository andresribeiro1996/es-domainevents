<?php


namespace command;
use App\robber\infrastructure\port\message\DomainEventConsumerInKafka;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DomainEventConsumerInKafkaTest extends KernelTestCase
{

    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find(DomainEventConsumerInKafka::getDefaultName());
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Username: Wouter', $output);

        // ...
    }
}