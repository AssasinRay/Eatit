<?php 
   $user = $_GET['User'];

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

    $queryStr = "SELECT * FROM Orders where seller='$user'";
    $query = mysqli_query($connection, $queryStr);

    if (!$query)
       echo "ERROR: " . mysqli_error($connection);
    else {
  //  $orders = array();
      $orders = '<p>Only click on "CONFIRM" after the transaction has been completed.</p><br />';
      $orders .= "<h4>Orders I've received: </h4>";

    while($row = mysqli_fetch_assoc($query)){
      //  $newRec = array();
        $content = "<b>" . $row['buyer'] . "</b>" . " placed an order on your item: " . '<b>' . $row['itemName'] . '</b>'. " on " . $row['date'] . '<br />';
        $content .=  $row['buyer'] . "'s message to you: " . $row['notes'] . '<br />';
        $content .=   $row['buyer'] . "'s phone number: " . $row['buyerContact'] . '<br />';
        $content .= "Order status: " . $row['status'] .  '<br /><br />';
        $orderID = $row['orderID'];
        $content .= '<div align="center"><button id="delete-rec-order" onclick="transaction_complete(\'' .$orderID . '\')">CONFIRM</button></div><br /><br />';
        $orders .= $content;
   //     array_push($newRec, $content);
   //     array_push($orders, $newRec);
      }

      $orders .= "<br />";
      $orders .= "<h4>Orders I've placed: </h4>";
      $queryStr2 = "SELECT * FROM Orders where buyer='$user'";
      $result = mysqli_query($connection, $queryStr2);
      if (!$result){
         echo "ERROR: " . mysqli_error($connection);
      }
      
      else {
          while($row = mysqli_fetch_assoc($result)){
          $content = "You have placed an order on " . $row['seller'] . "'s item: " . $row['itemName'] . " on " . $row['date'] . '<br />';
          $content .= "Your message to " . $row['seller'] . ": " . $row['notes'] . '<br /><br />';
          $orderID = $row['orderID'];
          $content .= '<div align="center"><button id="delete-place-order" onclick="deletePlacedOrder(\'' .$orderID . '\')">CANCEL THIS ORDER</button></div><br /><br />';
          $orders .= $content;
        }
      }

     echo $orders;

   }
?>