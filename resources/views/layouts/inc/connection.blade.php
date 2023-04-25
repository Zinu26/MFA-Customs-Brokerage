<?php

$dbhost = "localhost";
$user = "root";
$pass = "";
$dbname = "mfa";

if(!$con = mysqli_connect($dbhost,$user,$pass,$dbname)){
	die("failed to connect!");
}

//create a 404 connection not found

?>

