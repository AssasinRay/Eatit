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
     
       echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" class="item-img" /><br />';
     //   echo '<img src="data:image/jpeg;base64,' . base64_encode($new_img) . '" class="item-img" />';
      // echo '<img src="$image" width="150px" height="150px" >';
       echo "Name: " . "&nbsp;&nbsp;" . $row["item_name"] . "<br />"; 
       echo "Type:   "  . "&nbsp;&nbsp;" . $row["Type"] . "<br />";
       echo "Taste:   " . "&nbsp;&nbsp;" . $row["Taste"] . "<br />";
       echo "Prep time:   ". "&nbsp;&nbsp;" . $row["Ready_time"] . "<br />";
       $val = getCal($row["Nutrition"]);
       echo "Nutrition Info:   ". "&nbsp;&nbsp;" . $val . "<br />";
       echo "Price: ". "&nbsp;&nbsp;" . "$". $row["Price"] . "<br />";
       echo "Date Added:   " . "&nbsp;&nbsp;" . $row['Date_add'] . "<br />";
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
     function getCal($nutrition){
      switch($nutrition){
        case 1:
         $calories = "<200 cal";
         break;
        case 2:
         $calories = "200 - 399 cal";
         break;
        case 3:
         $calories = "400 - 599 cal";
         break;
        case 4:
         $calories = "600 - 799 cal";
         break;
        case 5:
         $calories = "800 - 999 cal";
         break;
        case 6:
         $calories = ">1000 cal";
         break;        
     }
    return $calories;
   }
    
?>