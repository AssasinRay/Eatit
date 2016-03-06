<?php

$server_name='engr-cpanel-mysql.engr.illinois.edu'
$user_name='localhost'
$password=''
$database_name="eatiteat_User"
$connection = mysql_connect(server_name,user_name, password);




if (!$connection){

    die("Database Connection Failed" . mysqli_connect_error());

}
echo "Connected successfully";
$select_db = mysql_select_db($database_name);

if (!$select_db){

    die("Database Selection Failed" . mysql_error());

}
echo "databaseconnection successfully";