<?php

session_start();

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");

if(!isset($_SESSION['username'])) {
	header("Location: index.view.php");
}

$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

$search = htmlspecialchars($_POST['search']);

if (!empty($search)) {
	$request['type'] = 'search';
	$request['beer'] = $search;
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	header('Location: beer.view.php');
	
}

var_dump(isset($_POST['logout']));

if (isset($_POST['logout'])) {
	session_destroy();
	header('Location: index.view.php');

}

require 'profile.view.php';

?>
