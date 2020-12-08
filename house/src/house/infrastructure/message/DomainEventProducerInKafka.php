<?php


namespace App\house\infrastructure\message;

use RdKafka;
use App\robber\application\DomainEventProducer;
use App\robber\domain\DomainEvent;

class DomainEventProducerInKafka implements DomainEventProducer
{
    /**
     * @var RdKafka\Producer
     */
    private $producer;

    public function __construct() {
        $conf = new RdKafka\Conf();
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->set('debug', 'all');
        $conf->set('metadata.broker.list', 'localhost:9092');
        $this->producer = new RdKafka\Producer($conf);
    }

    function produce(DomainEvent $domainEvent): void
    {
        $topic = $this->producer
            ->newTopic($domainEvent->getBoundedContextName(). '_' . $domainEvent->getAggregateName());

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($domainEvent->getData()));
        $this->producer->poll(0);

        $result = $this->producer->flush(10000);
        if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
            return;
        }

        if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
            throw new \RuntimeException('Was unable to flush, messages might be lost!');
        }
    }
}