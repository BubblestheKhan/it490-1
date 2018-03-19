<?php

require_once('rabbitMQLib.inc');
require_once('get_host_info.inc');
require_once('path.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());


$username = 'dmoon1';//htmlspecialchars($_POST['username']);
$password =  'password';//htmlspecialchars($_POST['password']);
$error = '';

if (isset($_POST['register'])) {
	require "register.view.php";

} elseif (true) {

	if (empty($username) || empty($password)) {
		$error = "Oops! Invalid Username/Password";
		header('Location: index.view.php');
		die();
		
	} else {
		$request = array();
		$request['type'] = "login";
		$request['username'] = $username;
		$request['password'] = $password;
		$request['message'] = "'{$userame}' requests to login '{$date}'";
		
		$response = $client->send_request($request);

		if ($response === '401') {
			$error = "Oops! Invalid Username/Password";
			header('Location: index.view.php');
			die();
			
		} elseif ($response === '404') {
			$error = "Oops! Username not found!";
			header('Location: index.view.php');
			die();
		
		} else {
			$_SESSION['username'] = $response[0]['username'];
			$_SESSION['firstname'] = $response[0]['firstname'];
			$_SESSION['lastname'] = $response[0]['lastname'];
			header("Location: profile.php");
		}
	}

}


?>

