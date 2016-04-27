<?php 
   $user = $_GET['User'];

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

    // 0 for request hasn't been answered, 1 for the contrary
    //$queryStr = "DELETE FROM ChatRequests where responder = '$user'"; // or initiator = '$user' ";
    $status = "completed";
    $queryStr = "UPDATE ChatRequests SET status = '$status' where responder='$user'";
    $query = mysqli_query($connection, $queryStr);
    //echo "success";
?>