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
			return doLogin($request['username'], $request['password']);

		case "logout":
			return doLogout($request['logout']);

		case "profile":
			return getProfile($request['username']);

		case "register":
			print_r($request);
			return doRegister($request['username'], $request['email'], $request['password'], $request['firstname'], $request['lastname']);

		case "searchBeer":
			return searchBeer($request['searchBeer']);

		case "searchCategory":
			return searchCategory($request['searchCategory']);
	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}


// Functions for beer related
// Searches for specific beer
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
		$request['type'] = "apiBeerSearch";
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


// Searches for categories of beers
function searchCategory($categorySearch) {
	try {
		$pdo = new PDO("mysql:host=localhost;dbname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo 'Connected Successfully'.PHP_EOL;

	} catch (PDOException $e) {
		echo "Connection Failed: " . $e->getMessage();
	
	}

	$result = $pdo->prepare("SELECT * FROM beer where category = '{$categorySearch}'");
	$result->execute();

	$row = $result->fetchAll();

	if (empty($row)) {
		echo "Could not find '{$categorySearch}' from local database\n";
		echo "Searching through the API database....";

		$client = new rabbitMQClient("testRabbitMQ.ini", "Backend");

		$request = array();
		$request['type'] = 'apiCategorySearch';
		$request['searchAPI'] = urlencode($categorySearch);
		$request['message'] = 'API Search for Category';

		$api_request = $client->send_request($request);

		insertBeer($api_request['name'], $api_request['description'], $api_request['type'], $api_request['available'], $api_request['category']);

		echo "Added Successfully";

		$result = $pdo->prepare("SELECT * FROM beer where category = '{$categorySearch}'");

		return $result->fetchAll();
	
	} else {

		return $row;
	}

}


// Insert Beer into LOCAL database for users
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

// Functions for User Profiling.
// Adds user to the localdatabase

function doLogin($username, $password) {

	$date = date("Y-m-d");
	$time = date("h:m:sa");

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo "Connected Successfully".PHP_EOL;
	
	} catch (PDOException $e) {
		echo "Connection Failed:" . $e->getMessage();
	
	}

	$result = $pdo->prepare("SELECT password FROM users WHERE username = '{$username}'");

	$result->execute();

	$row = $result->fetchAll();

	if (!empty($row)) {
		if (password_verify($password, $row[0]["password"])) {
			$log = "$date $time Response Code 202: Success!";

			$response = $pdo->prepare("SELECT username, firstname, lastname FROM users WHERE username = '{$username}'");
			$response->execute();

			$row = $response->fetchAll();

			return $row;
		
		} else {
			$response = '401';
			$log = "$date $time Response Code 401: Username $username, not authorized.\n";

		return $response;
		}
	
	} else {
		$response = "404";
		$log = "$date $time Response Code 404: Username not found.\n";

		return $response;
		
	
	}

}


function doRegister($username, $email, $password, $firstname, $lastname) {

	$date = date("Y-m-d");
	$time = date("h:m:sa");
	$options = ['length' => 11];
	$hash = password_hash($password, PASSWORD_DEFAULT, $options);

	try {
		$pdo = new PDO("mysql:host=localhost;dbname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		echo "Connected Successfully".PHP_EOL;

	} catch (PDOException $e) {
		echo "Connection Failed: ". $e->getMessage();
	}

	$result = $pdo->prepare("SELECT * FROM users where username = '{$username}'");
	$result->execute();

	$row = $result->fetchAll();

	if (!empty($row)) {
		$response = "302";
		$log = "$date $time Response Code 302: Username $username already registered.\n";

		return $response;

	} else {


		$statement = $pdo->prepare("INSERT INTO users (username, email, password, firstname, lastname) VALUES (:username, :email, :password, :firstname, :lastname)");

		$statement->bindParam(":username", $username);
		$statement->bindParam(":email", $email);
		$statement->bindParam(":password", $hash);
		$statement->bindParam(":firstname", $firstname);
		$statement->bindParam(":lastname", $lastname);

		$statement->execute();

		$response = "$username";
		$log = "$date $time Response Code 201: Email $email successfully added to the database. \n";

		return $response;

	}

}

function getProfile($username) {
	$date = date("Y-m-d");
	$time = date("h:m:sa");

	try {
		$pdo = new PDO("mysql:host=localhost;dname=HOP", "root", "root");
		$pdo->setAttribute(PDO::ATTR_ERRRMODE, PDO::ERRMODE_EXCEPTION);

		echo "Connected Successsfully".PHP_EOL;

	} catch (PDOException $e) {
		echo "Connection Failed: ". $e->getMessage();

	}

	$result = $pdo->prepare("SELECT * from users WHERE username = '{$username}'");
	$result->exec();
	$row = $result->fetchAll();

	return $row;


}

$server = new rabbitMQServer("testRabbitMQ.ini", "Frontend");
$server->process_requests('requestProcessor');

exit();

?>