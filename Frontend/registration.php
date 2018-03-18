<?php

require_once("rabbitMQLib.inc");
require_once("get_host_info.inc");
require_once("path.inc");

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$confirmPassword = htmlspecialchars($_POST['confirmPassword']);
$email = htmlspecialchars($_POST['email']);
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);

$missingError = '';
$validateError = '';


if (isset($_POST['register'])) {
	if ((empty($username)) or ((empty($email)) or ((empty($password))) or ((empty($firstname))) or ((empty($lastname))))) {
		$missingError = "Oops! You are missing some fields."; 
	
		if ($confirmPassword != $password) {
			$validateError = "Oops! Password did not match.";

		}

		require 'register.view.php';
	
	} else {

		$request = array();
		$request['type'] = "register";
		$request['username'] = $username;
		$request['password'] = $password;
		$request['email'] = $email;
		$request['firstname'] = $firstname;
		$request['lastname'] = $lastname;
		$request['message'] = "'{$username}' has been registered '{$date}'";

		$response = $client->send_request($request);

		require 'index.view.php';
		
	}
} 
	




?>

