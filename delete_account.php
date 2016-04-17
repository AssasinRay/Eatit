<?php 
    session_start();

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
    
    $username = $_SESSION['name'];

    $query1 = "DELETE from User where Username='$username'";
    
    $result1 = mysqli_query($connection,$query);

    $query2 = "DELETE from Product where Username='$username'";
    
    $result2 = mysqli_query($connection,$query);


	if($result1 && $result2){
        session_unset();
        header('Location: index.php');
      }
     else
     {
       	echo "Unknown Error: operation cannot be performed.";
     }
   
?>