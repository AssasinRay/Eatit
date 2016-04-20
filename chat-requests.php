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
		// <script> alert('connection fail')</script>
	    die("Database Connection Failed" . mysqli_connect_error());
	}

    $select_db = mysqli_select_db($connection,$database_name);
    	if (!$select_db){
		// <script> alert('databaseselection fail')</script>
	    die("Database Selection Failed" . mysql_error());
	}

    // 0 for request hasn't been answered, 1 for the contrary
    $queryStr = "INSERT INTO ChatRequests (initiator, responder, url) values ('$initiator','$responder', '$url')";
    $query = mysqli_query($connection, $queryStr);
    if (!$query)
       echo "ERROR: " . mysqli_error($connection)

   // echo "requested";
?>
