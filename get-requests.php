<?php 
   $user = $_GET['User'];

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
    $queryStr = "SELECT * FROM ChatRequests where responder = '$user'"; // or initiator = '$user' ";
    $query = mysqli_query($connection, $queryStr);

    $get_rows= mysqli_affected_rows($connection);

    if($get_rows != 0){
    		while($row = mysqli_fetch_array($query)){
    			echo "<b>" . $row['initiator'] . "</b>" . " wants to chat with you" . "&nbsp;&nbsp;&nbsp;&nbsp;";
				$url = $row['url'];
				//echo '<form method="link" action="' . $url . '">' . '<input type="submit" value="Accept"></form>';
				echo '<button id="accept-chat" onclick="accept_chat(\'' .$url . '\')">Accept</button>';
				echo '<br /><br />'; 
			}
    }

   // echo "requested";
?>
