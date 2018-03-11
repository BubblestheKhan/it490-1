<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'dmoon', 'password');
$channel = $connection->channel();

$channel->queue_declare('rpc_queue', false, false, false, false);

