<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);
$error = ini_set('error_log', dirname(__FILE__) . '/errorlog.txt');
$log = '/errorlog.txt';
require 'heyo';
?>
