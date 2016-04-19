<?php 
   $item = $_POST['Item'];
   $buyer = $_POST['Buyer'];
   $seller = $_POST['Seller'];
   $notes = $_POST['Notes'];

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


    $queryStr = "INSERT INTO Orders (buyer, seller, itemName, notes) values ('$buyer', '$seller', '$item', '$notes')";
    $query = mysqli_query($connection, $queryStr);
    if (!$query)
       echo "ERROR: " . mysqli_error($connection);
    echo "order success";
?>