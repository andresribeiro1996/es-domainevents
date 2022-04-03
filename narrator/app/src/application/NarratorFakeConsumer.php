<?php


namespace Narrator\application;


use Ratchet\ConnectionInterface;
use React\EventLoop\Factory;
use React\Socket\Connector;
use WebSocket\Client;
use WebSocket\Message\Text;
use function Ratchet\Client\connect;

class NarratorFakeConsumer implements Consumer
{

    /** @var array */
    private $messages = [];
    /**
     * @var WebsocketService
     */
    private $websocketService;

    /**
     * NarratorFakeConsumer constructor.
     * @param WebsocketService $websocketService
     */
    public function __construct(WebsocketService $websocketService)
    {
        $this->websocketService = $websocketService;
    }

    public function consume()
    {
        $this->bootstrapMessages();

        echo 'before connect';
        while (true) {
            sleep(1);
            $client = new Client("ws://127.0.0.1:8083");
            try {
                $client->send('hello, im narrator');
                $obj = $client->receive();
                echo $obj;
            } catch (\Throwable $e) {
                echo $e->getMessage() . "\n";
            }
//            connect('ws://127.0.0.1:8083')->then(function ($conn) {
//                echo "Entered infinite cycle\n";
//                $conn->on('message', function ($msg) use ($conn) {
//                    echo "Received: {$msg}\n";
//                });
//
//                $conn->send('Hello World!');
//                echo 'hello world';
//            }, function ($e) {
//                echo "Could not connect: {$e->getMessage()}\n";
//            }, function ($e) {
//                echo 'progress';
//            }
            //);
        }
    }


    public function bootstrapMessages(): void
    {
        $this->messages = [
            ['message1'],
            ['message2'],
            ['message3'],
            ['message4'],
            ['message5'],
        ];
    }
}