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
/*

    $query1 = "DELETE from User where Username='$username'";
    
    $result1 = mysqli_query($connection,$query);

    $query2 = "DELETE from Product where Username='$username'";
    
    $result2 = mysqli_query($connection,$query);
*/
   // $query = "delete from User full join Product.Username on User.Username = Product.Username";
  //  $query = "DELETE a FROM User AS a INNER JOIN Product AS b ON a.Username = b.Username";
    $query1 = "DELETE User, Product from User LEFT JOIN Product on User.Username = Product.Username where User.Username = '$username'";
    $result1 = mysqli_query($connection, $query1);

    $query2 = "DELETE from Chatlog where sender = '$username' or receiver = '$username'";
    $result2 = mysqli_query($connection, $query2);

	if($result1 && $result2){
        session_unset();
        header('Location: index.php');
      } 
     else
     {
       	echo "Unknown Error: operation cannot be performed.";
     }
   
?>