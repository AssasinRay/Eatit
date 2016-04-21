<?php 
session_start();

	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$password="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $password);
	$select_db = mysqli_select_db($connection,$database_name);

	$username = $_SESSION['name'];

	$t = time();
    $updateT = "UPDATE User SET LastLogOut= '$t' where Username='$username' ";
	$res = mysqli_query($connection,$updateT);

session_unset();
header('Location: index.php');


?>