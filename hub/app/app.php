#!/usr/bin/env php
<?php
// infrastructure.php

require __DIR__ . '/vendor/autoload.php';

use Narrator\infrastructure\Hub;
use Ratchet\Server\IoServer;

//$hub = new Hub();
//$server = IoServer::factory(
//    $hub,
//    8083
//);
//$server->run();

$server = new WebSocket\Server(['port' => 8083]);
echo "Server started";
while ($server->accept()) {
    try {
        $message = $server->receive();
        echo 'message received: ' . $message . "\n";
        $server->send($message);
        // Act on received message
        // Break while loop to stop listening
    } catch (\WebSocket\ConnectionException $e) {
        // Possibly log errors
    }
}
$server->close();