<?php 
   $uname = $_GET['uname'];
   $receiver = $_GET['receiver'];
   $msg = $_GET['msg'];

   $server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
		if (!$connection){
		// <script> alert('connection fail')</script>
	    die("Database Connection Failed");
	}

    $select_db = mysqli_select_db($connection,$database_name);
    	if (!$select_db){
		// <script> alert('databaseselection fail')</script>
	    die("Database Selection Failed" );
	}

    $queryStr = "INSERT INTO Chatlog (sender, receiver, Log) values ('$uname', '$receiver','$msg')";
    $query = mysqli_query($connection, $queryStr);

    echo $uname .  ":   " . $msg;

?>
