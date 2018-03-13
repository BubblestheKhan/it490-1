<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request) {
	echo "Request received".PHP_EOL;

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	switch ($request['type']) {

		case "login":
			return doLogin($request['login']);

		case "logout":
			return doLogout($request['logout']);

		case "register":
			return doRegister($request['register']);

		case "search":
			return searchBeer($request['searchBeer']);
	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

function searchBeer($beerSearch) {

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo 'Connected Successfully'.PHP_EOL;

	} catch (PDOException $e) {
		echo "Connection Failed: " . $e->getMessage();
	
	}

	$result = $pdo->prepare("SELECT * FROM beer where name = '{$beerSearch}'");
	$result->execute();

	$row = $result->fetchAll();

	if (empty($row)) {
		echo "Could not find '{$beerSearch}' from local database\n";
		echo "Searching through the API database....";

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = "apisearch";
		$request['searchAPI'] = urlencode($beerSearch);
		$request['message'] = 'API Search for Beer';

		$api_request = $client->send_request($request);

		insertBeer($api_request['name'], $api_request['description'], $api_request['type'], $api_request['available'], $api_request['category']);

		echo "Added Successfully";

		$result = $pdo->prepare("SELECT * FROM beer where name = '{$beerSearch}'");
		$result->execute();

		return $result->fetchAll();
	} else {
		return $row;
	}
}

function insertBeer($name, $description, $type, $available, $category) {

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo 'Connected Successfully'.PHP_EOL;

	} catch (PDOException $e) {
		echo "Connection Failed: " . $e->getMessage();
	
	}

	$statement = $pdo->prepare("INSERT INTO beer (name, description, type, available, category) VALUES (:name, :description, :type, :available, :category)");

	$statement->bindParam(':name', $name);
	$statement->bindParam(':description', $description);
	$statement->bindParam(':type', $type);
	$statement->bindParam(':available', $available);
	$statement->bindParam(':category', $category);

	$statement->execute();

}

$server = new rabbitMQServer("testRabbitMQ.ini", "Frontend");
$server->process_requests('requestProcessor');

exit();


?>