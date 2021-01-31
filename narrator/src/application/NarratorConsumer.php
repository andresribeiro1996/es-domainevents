<?php

namespace Narrator\application;

use Narrator\domain\NarratorEvent;
use Narrator\domain\OrganismEvent;
use RdKafka;
use RdKafka\KafkaConsumer;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;

/**
 * Class OrganismConsumer
 * This class is responsible to make connection between message broker and a websocket
 * It consumes a kafka and sends it to a websocket
 */
class NarratorConsumer
{
    protected static $defaultName = 'kafka:organism-consumer';

    private const CONSUMABLE_TOPICS = ['robber_robber', 'house_house'];

    /**
     * @var KafkaConsumer
     */
    private $consumer;

    private $client;

    public function __construct()
    {
        $loop = Factory::create();
        $this->client = new Connector($loop);

        $conf = new RdKafka\Conf();

        // Configure the group.id. All consumer with the same group.id will consume
        // different partitions.
        $conf->set('group.id', 'narrator');

        // Initial list of Kafka brokers
        $conf->set('metadata.broker.list', getenv('KAFKA_HOST'));

        // Set where to start consuming messages when there is no initial offset in
        // offset store or the desired offset is out of range.
        // 'earliest': start from the beginning
        $conf->set('auto.offset.reset', 'earliest');

        $this->consumer = new RdKafka\KafkaConsumer($conf);

        // Subscribe to topic 'test'
        $this->consumer->subscribe(self::CONSUMABLE_TOPICS);

        echo "Waiting for partition assignment... (make take some time when\n";
        echo "quickly re-joining the group after leaving it.)\n";
    }

    public function consume()
    {
        $cn = $this->client->connect('localhost:8083');

        while (true) {
            $message = $this->consumer->consume(120 * 1000);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $result = json_decode($message->payload, true);

                    $organismEvent = new NarratorEvent(
                        $result['event_name'],
                        $result['aggregate_id'],
                        $result['aggregate_name'],
                        [
                            'topic' => $message->topic_name,
                            'payload' => $message->payload,
                            'timestamp' => $message->timestamp
                        ]
                    );

                    $cn->then(function (ConnectionInterface $connection) use ($organismEvent) {
                        $connection->write($organismEvent->toArray());
                        $connection->end();
                    });

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