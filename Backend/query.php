<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request) {
	echo "received request".PHP_EOL;

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	switch ($request['type']) {
		case "search":
			return searchAll($request['beerSearch']);
	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}


function searchAll($beerSearch) {

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo 'Connected Successfully';

	} catch (PDOException $e) {
		echo "Connection Failed: " . $e->getMessage();
	
	}

	$result = $pdo->prepare("SELECT * FROM beer where name = '{$beerSearch}'");
	$result->execute();

	$row = $result->fetchAll();
	$response = array();
	foreach ($row as $value) {
		array_push($response, $value);
	}

	var_dump($response);

	return $response;
}


$server = new rabbitMQServer("testRabbitMQ.ini", "testServer");
$server->process_requests('requestProcessor');

exit();

?>