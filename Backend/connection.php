<?php

$database = require 'config.php';

try {

	$pdo = new PDO("mysql:host=" . $database['host'] . ";dbname=" . $database['database'], $database['username'], $database['password']);
	
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	echo "Connected Successfully";

} catch (PDOException $e) {
	echo "Connection Failed: " . $e->getMessage();

}