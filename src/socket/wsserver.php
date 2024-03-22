<?php
use Workerman\Worker;
use Workerman\Connection\TcpConnection;

require_once __DIR__ . './../vendor/autoload.php';

$ws_worker = new Worker("websocket://0.0.0.0:8282");
$ws_worker->count = 1;

$ws_worker->onConnect = function($connection) use (&$ws_worker){
};

$ws_worker->onMessage = function(TcpConnection $connection, $data) use (&$ws_worker)
{
};

$ws_worker->onWorkerStart = function() use (&$ws_worker){
};

$ws_worker->onClose = function($connection) use (&$ws_worker){
};

Worker::runAll();