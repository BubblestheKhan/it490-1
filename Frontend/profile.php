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


require 'profile.view.php';

?>
