<?php 
   $item = $_POST['Item'];
   $buyer = $_POST['Buyer'];
   $seller = $_POST['Seller'];
   $notes = $_POST['Notes'];
   $status = "in progress";
   $seen = "no";

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

   $getPhone = "SELECT * FROM User where Username = '$buyer'";
   $result = mysqli_query($connection, $getPhone);
  if (!$result)
       echo "ERROR: " . mysqli_error($connection);

   while($row = mysqli_fetch_assoc($result)){
        $phoneNum = $row['phone_num'];
        break;
      }
   
    $queryStr = "INSERT INTO Orders (buyer, seller, itemName, notes, buyerContact, status, seen) values ('$buyer', '$seller', '$item', '$notes', '$phoneNum', '$status', '$seen')";
    $query = mysqli_query($connection, $queryStr);
    if (!$query)
       echo "ERROR: " . mysqli_error($connection);
    echo "order success";
?>