<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

if (isset($_POST['beerName'])){
	$request = array();
	$request['type'] = "search";
	$request['beerSearch'] = $_POST['beerName'];
	$request['message'] = 'Test Search';

	$response = $client->send_request($request);

	require('beer.view.php');

} else {
	
	require 'index.view.php';

	
}

?>

