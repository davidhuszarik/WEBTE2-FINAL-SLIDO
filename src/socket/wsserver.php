<?php

use Workerman\Connection\TcpConnection;
use Workerman\Worker;

require_once __DIR__ . './../vendor/autoload.php';

$ws_worker = new Worker("websocket://0.0.0.0:8282");
$ws_worker->count = 1;

$ws_worker->onConnect = function ($connection) use (&$ws_worker) {
    echo "New connection\n";
};

$ws_worker->onMessage = function (TcpConnection $connection, $data) use (&$ws_worker) {
};

$ws_worker->onWorkerStart = function () use (&$ws_worker) {
    echo "Worker started\n";
};

$ws_worker->onClose = function ($connection) use (&$ws_worker) {
    echo "Connection closed\n";
};

function broadcast($message) {
    global $ws_worker;
    foreach ($ws_worker->connections as $connection) {
        $connection->send($message);
    }
}

Worker::runAll();