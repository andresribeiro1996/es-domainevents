<?php

namespace Narrator\application;

class NarratorService
{
    public function __construct(bool $useFakeKafka) {

        if(!$useFakeKafka) {
            $consumer = new NarratorKafkaConsumer();
        } else {
            $consumer= new NarratorFakeConsumer(new WebsocketService());
        }

        try {
            $consumer->consume();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}