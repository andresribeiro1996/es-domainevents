<?php


namespace Narrator\application;


interface WebsocketInterface
{

    public function connect();

    public function send(array $message);
}