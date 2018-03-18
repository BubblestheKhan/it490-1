<?php

require_once('rabbitMQLib.inc');
require_once('get_host_info.inc');
require_once('path.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());

$username = $_POST['username'];
$password = $_POST['password'];

if (isset($_POST['register'])) {
	header('Location: register.view.php');

} elseif (isset($_POST['login'])) {

	if (empty($username) || empty($password)) {
		header("Location: index.view.php");
		
	} else {
		$request = array();
		$request['type'] = "login";
		$request['username'] = $username;
		$request['password'] = $password;
		$request['message'] = "'{userame}' requests to login '{$date}'";

		$response = $client->send_request($request);
	}

}


?>

