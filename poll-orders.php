<?php 
   $user = $_GET['User'];
  // $count = $_GET['Count'];

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

    $status = "in progress";
    $seen = "no";
    $queryStr = "SELECT * FROM Orders where seller = '$user' and status='$status' and seen='$seen'";
    $query = mysqli_query($connection, $queryStr);
    if (!$query)
     echo "ERROR: " . mysqli_error($connection);

    $get_rows= mysqli_affected_rows($connection);
    if ($get_rows > 0){
        echo "alert";
        $seen = "yes";
        $newQuery = "UPDATE Orders SET seen='$seen' where seller = '$user' and status='$status'";
        $query = mysqli_query($connection, $newQuery);
    }
?>