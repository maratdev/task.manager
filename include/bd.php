<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbName = 'taskmanager';

define("REQUEST", $_SERVER["REQUEST_URI"]);

$link = mysqli_connect($host, $user, $password, $dbName);
mysqli_query($link, "SET NAMES 'utf8'") or die(mysqli_error($link));



