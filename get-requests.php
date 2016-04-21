<?php 
   $user = $_GET['User'];

   $server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
		if (!$connection){
	    die("Database Connection Failed" );
	}

    $select_db = mysqli_select_db($connection,$database_name);
    	if (!$select_db){
	    die("Database Selection Failed");
	}

    // first display pending requests
    $status = "pending";
    $queryStr = "SELECT * FROM ChatRequests where responder = '$user' AND status= '$status'"; 
    $query = mysqli_query($connection, $queryStr);

    $get_rows= mysqli_affected_rows($connection);
    $output = "<h4>Pending Chat Requests: </h4>";

    if($get_rows != 0){

			while($row = mysqli_fetch_assoc($query)){
				$content = "<b>" . $row['initiator'] . "</b>" . " wants to chat with you" . "&nbsp;&nbsp;&nbsp;&nbsp;";
				$url = $row['url'];
				$content .= '<button id="accept-chat" onclick="accept_chat(\'' .$url . '\')">Accept</button><br /><br />';
				$output .= $content;
		}
}
     else
        $output .= "<p>You have no pending chat request at this time.</p>";

	 $output .= "<br /><h4>My Chat History: </h4>";
     $status = "completed";
	 
	// $queryStr2 = "SELECT DISTINCT initiator, responder FROM ChatRequests where status= '$status'"; // Distinct initiator
       $queryStr2 = "SELECT initiator, responder, url FROM ChatRequests GROUP BY initiator, responder";
	      $result = mysqli_query($connection, $queryStr2);
	      if (!$result){
	         echo "ERROR ";
	      }
	      
	      else {
	          while($row = mysqli_fetch_assoc($result)){
	          	    if ($user == $row['initiator'])
	          	    	$person = $row['responder'];
	          	    else 
	          	    	$person = $row['initiator'];
	          		$content = "My chat with " . "<b>" . $person . "</b>" . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$url = $row['url'];
					$content .= '<button id="accept-chat" onclick="view_chat(\'' .$url . '\')">View Conversation</button><br /><br />';
					$output .= $content;
	        }
	      }

	      echo $output;


?>
