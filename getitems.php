<?php 
    ob_start();
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
   
    $username = $_POST['name'];
	$result = mysqli_query($connection, "SELECT * FROM Product where Username='$username'");
    
 
    while($row = mysqli_fetch_array($result)){
       echo "<div class=\"\">";
     //  header("Content-type: image/jpeg");
     //  echo '<img src="' . $row['image'] . '" class="image" />';
       echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="item-img" />';

      // echo '<img src="$image" width="150px" height="150px" >';
       echo "Name: ". $row["item_name"] . "<br />"; 
       echo "Type: ". $row["Type"] . "<br />";
       echo "Taste: ". $row["Taste"] . "<br />";
       echo "Prep time: ". $row["Ready_time"] . "<br />";
       echo "Nutrition Info: ". $row["Nutrition"] . "<br />";
       echo "Price: $". $row["Price"] . "<br />";
       echo "Date Added: " . $row['Date_add'] . "<br />";
      /*
       ?><script>
         sessionStorage.item_del = <?php echo $row["item_name"]; ?>;
       </script><?php
     */
       $temp = $row["item_name"];
       echo '<button id="delete-item" onclick="delete_item(\'' .$temp . '\')">DELETE ITEM</button>';
      
      // echo "<button id=\"delete-item\" >DELETE ITEM</button>";
       echo "<div id='clearfloat'></div>";
       echo "<hr />"; 
       echo "</div>";
    } 

    //$array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //echo json_encode($array);
  
    
?>