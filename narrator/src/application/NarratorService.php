<?php

namespace Narrator\application;

class NarratorService
{
    public function __construct() {
        $consumer = new NarratorConsumer();

        try {
            $consumer->consume();
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}