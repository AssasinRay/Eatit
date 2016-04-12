<?php 
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

    $item = $_POST['item_name'];

    $query = "DELETE from Product where item_name = '$item' " ;
    $result = mysqli_query($connection, $query);
    if (!$result)
         echo "Unknown Error: failed to delete item";
     
?>