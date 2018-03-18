<?php

require_once("rabbitMQLib.inc");
require_once("get_host_info.inc");
require_once("path.inc");

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());

$options = ['length' => 11];

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$confirmPassword = htmlspecialchars($_POST['confirmPassword']);
$hash = password_hash($passwd, PASSWORD_DEFAULT, $options);
$email = htmlspecialchars($_POST['email']);

$missingError = '';
$validateError = '';


if (isset($_POST['register'])) {
	if ((empty($username)) or ((empty($email)) or ((empty($password))))) {
		$missingError = "Oops! You are missing some fields."; 
	
		if ($confirmPassword != $password) {
			$validateError = "Oops! Password did not match.";

		}
		var_dump($_POST['password']);
		var_dump($username);
		var_dump($password);
		var_dump($email);

		require 'register.view.php';
	
	} else {

		$request = array();
		$request['type'] = "register";
		$request['username'] = $username;
		$request['password'] = $hash;
		$request['email'] = $email;
		$request['message'] = "'{userame}' has been registered '{$date}'";

		$response = $client->send_request($request);

		header('Location: index.view.php');
	}
} 
	




?>

