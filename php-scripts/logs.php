<?php 
   $one = $_GET['participant1'];
   $two = $_GET['participant2'];

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

    $query = "SELECT * FROM Chatlog where sender ='$one' and receiver = '$two'  union select * FROM Chatlog where sender ='$two' and receiver = '$one' order by Id asc"; 
  //  $query = "SELECT * from Chatlog where Username= 'one' "; 
    $result1 = mysqli_query($connection, $query); 

    $get_rows= mysqli_affected_rows($connection);
    if ($get_rows > 0){
           while($extract = mysqli_fetch_array($result1)){ // before it was fetch_array
              echo $extract['sender'] . ":   " . $extract['Log'] . "<br />";
     }
    }

?>
