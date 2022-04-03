<?php


namespace Narrator\application;



use React\EventLoop\Factory;
use React\Promise\PromiseInterface;
use React\Promise\RejectedPromise;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;

class WebsocketService implements WebsocketInterface
{

    /**
     * @var Connector
     */
    private $client;

    /**
     * @var PromiseInterface|RejectedPromise
     */
    private $cn;

    public function __construct() {

        $loop = Factory::create();
        $this->client = new Connector($loop);
    }

    /**
     * @return PromiseInterface|RejectedPromise
     */
    public function connect() {
        return $this->client->connect('localhost:8083');
    }

    public function send(array $message) {
        $this->cn->then(function (ConnectionInterface $connection) use ($message) {
            $connection->write($message[0]);
            echo "Message sent: " . $message[0] . "\n";
            $connection->close();
        });
    }
}