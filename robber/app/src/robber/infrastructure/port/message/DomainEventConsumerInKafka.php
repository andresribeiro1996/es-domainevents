<?php

namespace App\robber\infrastructure\port\message;

use App\robber\application\DomainEventConsumer;
use App\robber\domain\DomainEventFactory;
use App\robber\DomainEventPublisher;
use RdKafka;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DomainEventConsumerInKafka extends Command implements DomainEventConsumer
{
    protected static $defaultName = 'kafka:domain-event-consumer';

    private const CONSUMABLE_TOPICS = ['house_house'];

    /**
     * @var RdKafka\KafkaConsumer
     */
    private $consumer;

    protected function configure()
    {
        $this
            ->setDescription('Consumes domain events from organism')
        ;
    }

    public function __construct()
    {
        $conf = new RdKafka\Conf();

        // Configure the group.id. All consumer with the same group.id will consume
        // different partitions.
        $conf->set('group.id', 'robber2');

        // Initial list of Kafka brokers
        $conf->set('metadata.broker.list', getenv('KAFKA_URL'));

        // Set where to start consuming messages when there is no initial offset in
        // offset store or the desired offset is out of range.
        // 'earliest': start from the beginning
        $conf->set('auto.offset.reset', 'earliest');

        $this->consumer = new RdKafka\KafkaConsumer($conf);

        // Subscribe to topic 'test'
        $this->consumer->subscribe(self::CONSUMABLE_TOPICS);

        echo "Waiting for partition assignment... (make take some time when\n";
        echo "quickly re-joining the group after leaving it.)\n";

        parent::__construct(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Started consuming topics...',
        ]);

        try {
            $this->consume($output);
        } catch (\Exception $e) {
            return Command::FAILURE;
        }
        return Command::SUCCESS;
    }

    private function consume(OutputInterface $output)
    {
        while (true) {
            $message = $this->consumer->consume(120*1000);
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $output->writeln([
                        '<info>Topic: ' . $message->topic_name . '</info>',
                        '<info>Payload: ' . $message->payload . '<info>',
                        '<comment>Timestamp: ' . $message->timestamp . '</comment>',
                        '================================',
                    ]);

                    $result = json_decode($message->payload, true);

                    if(!$result) {
                        echo $message->payload .'';
                        continue;
                    }
                    DomainEventPublisher::instance()->publish([
                        DomainEventFactory::new(json_decode($message->payload, true))
                    ]);
                    break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    throw new \Exception($message->errstr(), $message->err);
            }
        }
    }
}