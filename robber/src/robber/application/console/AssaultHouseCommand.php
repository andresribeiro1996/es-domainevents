<?php

namespace App\robber\application\console;

use App\robber\application\RobberApplicationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AssaultHouseCommand extends Command
{
    protected static $defaultName = 'domain:assault-house';

    /**
     * @var RobberApplicationService
     */
    private $robberService;

    public function __construct(RobberApplicationService $robberService)
    {
        $this->robberService = $robberService;
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a robber and assaults a house')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->robberService->assaultHouseOfId(1, 1);
        $robber = $this->robberService->findRobber(1);

        if($robber) {
            $output->writeln([
                '<comment>Id: ' . $robber->getId()->id() . '</comment>',
                '<info>Name: ' . $robber->getName() . '</info>',
                '<info>Level: ' . $robber->getLevel() . '<info>',
                '================================',
            ]);
        } else {
            $output->writeln('robber is null');
        }

        return Command::SUCCESS;
    }
}