#!/usr/bin/env php
<?php
// infrastructure.php

require __DIR__ . '/vendor/autoload.php';

use Narrator\infrastructure\Hub;
use Ratchet\Server\IoServer;

$server = IoServer::factory(
    new Hub(),
    8083
);

$server->run();