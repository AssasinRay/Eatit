<?php 
   $orderID = $_GET["ID"];
   $status = $_GET['Status'];

   $server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
		if (!$connection){
	    die("Database Connection Failed");
	}

    $select_db = mysqli_select_db($connection,$database_name);
    	if (!$select_db){
	    die("Database Selection Failed" );
	}

  if ($status != "complete") {
    $queryStr = "DELETE FROM Orders where orderID = '$orderID'";
    $query = mysqli_query($connection, $queryStr);
    if (!$query)
       echo "ERROR: " . mysqli_error($connection);
  }
  else {
    $queryStr = "UPDATE Orders SET status = '$status' where orderID = '$orderID'";
    $result = mysqli_query($connection, $queryStr);
    if (!$result)
       echo "ERROR: " . mysqli_error($connection);
  
     $_GET['Status'] = "";
  }


?>