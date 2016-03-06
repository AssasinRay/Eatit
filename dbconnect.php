<?php

$server_name="engr-cpanel-mysql.engr.illinois.edu";
$user_name="eatiteat_Ray";
$password="l!Jkaqc2)Z%J";
$database_name="eatiteat_User";
$connection = mysqli_connect($server_name,$user_name, $password);

if (!$connection){

	// <script> alert('connection fail')</script>
    die("Database Connection Failed" . mysqli_connect_error());

}
echo "Connected successfully";
$select_db = mysqli_select_db($connection,$database_name);

if (!$select_db){

	// <script> alert('databaseselection fail')</script>
    die("Database Selection Failed" . mysql_error());

}
echo "databaseconnection successfully";
