<?php

require_once("rabbitMQLib.inc");
require_once("get_host_info.inc");
require_once("path.inc");

$options = ['length' => 11];

$username = $_POST['username'];
$password = $_POST['password'];
$hash = password_hash($passwd, PASSWORD_DEFAULT, $options);
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$request = array();
$request['type'] = "login";
$request['username'] = $username;
$request['password'] = $password;
$request['firstname'] = $firstname;
$request['lastname'] = $lastname;

$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

$response = $client->send_request($request);

require 'registration.html';

?>

