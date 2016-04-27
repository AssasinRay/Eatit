<?php 
   $initiator = $_GET['initiator'];
   $responder = $_GET['responder'];
   $url = $_GET['URL'];

   $server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
		if (!$connection){
	    die("Database Connection Failed" . mysqli_connect_error());
	}

    $select_db = mysqli_select_db($connection,$database_name);
    	if (!$select_db){
	    die("Database Selection Failed" . mysql_error());
	}

    $status = "pending";
    $seen = "no";
    $queryStr = "INSERT INTO ChatRequests (initiator, responder, url, status, seen) values ('$initiator','$responder', '$url', '$status', '$seen')";
    $query = mysqli_query($connection, $queryStr);
    if (!$query)
       echo "ERROR: " . mysqli_error($connection)

?>
