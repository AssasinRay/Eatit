<?php 
require('yelp.php');
   session_start();
/*
   	if (!$_SESSION['queryString'])
   		header('Location: user.php');
*/

   	if (empty($_SESSION['queryString']) && empty($_POST['search'])){
   		?>
   			<script>  
   			    alert("This page cannot be refreshed. Please start a new search.");
   				history.go(-1); 
   			</script>
   		<?php
   	}

   	   	
	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
	$items = array();
	$users = array();
	//recommended items
	$items_search_result=array();
	$items_recommend = array();
	$location="Champaign,IL";
	$yelp_recommend=array();

	if (!$connection){
	    die("Database Connection Failed");
	}
	$select_db = mysqli_select_db($connection,$database_name);
	if (!$select_db){
	    die("Database Selection Failed");
	}
	 
	        if ($_SESSION['queryString'])
            	$query = $_SESSION['queryString'];
            else
            	$query = $_POST['search'];

			$result = mysqli_query($connection, "SELECT * FROM Product where item_name like '%$query%' ");

			while($row = mysqli_fetch_assoc($result)){
				$newItem = array();
				$search_item=array();
				$newItem['img'] = '<div class=\"user-info\"><img src="data:image/jpeg;base64,' . base64_encode($row['image']). '" class="item-img" width="400px" height="300px" /><br />';
				$newItem['item_name'] = "<b>Item: " ."&nbsp;&nbsp;&nbsp;</b>". $row['item_name'];
				$newItem['Type'] = "<b>Type: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Type'];
				$newItem['Taste'] = "<b>Taste: " ."&nbsp;&nbsp;&nbsp;</b>" . $row['Taste'];
				$newItem['Ready_time'] = "<b>Prep time: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Ready_time'];
				$newItem['Nutrition']= "<b>Nutrition Info: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Nutrition'];
			    $newItem['Price'] = "<b>Price: " ."&nbsp;&nbsp;&nbsp;</b>". "$". $row['Price'];
			    $newItem['Date'] = "<b>Date Added: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Date_add'];
			    $newItem['Seller'] = "<b>Sold by: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Username'];
			    $search_item['item_name']=$row['item_name'];
			    $search_item['Type']=$row['Type'];
			    $search_item['Taste']=$row['Taste'];
			    $search_item['Nutrition']=$row['Nutrition'];
			    $search_item['Price']=$row['Price'];
			 //   $newItem['order-item'] = $row['item_name'];
			 //   $newItem['order-seller'] = $row['Username'];

			    $cur = array();
			    array_push($cur, $row['item_name'], $row['Username'], $_SESSION['name']);
			    $details = implode(",", $cur);
			    $newItem['Order'] = '<button id="order-item" onclick="order_item(\'' . $details . '\')">ORDER</button><br />';
                /*
                if(isOnline($row['Username'], $connection) == true)
                	//$newItem['chat'] = "<button onclick=\"chat()\">Chat</button>";
                	$newItem['chat'] = "TRUE";
                else
                	$newItem['chat'] = "False";
                	*/
                $user = $row['Username'];	
                $temp1 = mysqli_query($connection, "SELECT LastLogIn FROM User where Username='$user'");
				$temp2 =mysqli_query($connection, "SELECT LastLogOut FROM User where Username='$user'");	

                
				 while ($row = mysqli_fetch_assoc($temp1)) {
       				 $lastLogin = $row['LastLogIn'];
       				 break;
   				 } 

   				 while ($row2 = mysqli_fetch_assoc($temp2)) {
       				 $lastLogOut = $row2['LastLogOut'];
       				 break;
   				 } 

				if ($lastLogin > $lastLogOut )
					$newItem['chat'] =  '<button onclick="chat(\'' . $user . '\')">Chat</button>';
				else
					$newItem['chat'] = "";

			    array_push($items, $newItem);
			    array_push($items_search_result,$search_item);
		
			}

             /*
			$result2 =  mysqli_query($connection, "SELECT * FROM User where Username like '%$query%' ");
			while($row = mysqli_fetch_assoc($result2)){
				$newItem = array();
				$newItem['item_name'] = "<div class=\"user-info\"><b>Item: " ."&nbsp;&nbsp;&nbsp;</b>". $row['item_name'];
				
			    array_push($items, $newItem);
			}
		    */

			 $items_recommend=recommend_system($connection,$items_search_result);
			if (!empty($items))
				 $_SESSION["h3"] = "We've found the following items for you: ";
			else
			 	 $_SESSION["h3"] = "Sorry, no matching results were found."; 

			 recommend_yelp($location,$items_search_result);

	function recommend_yelp($location,$items_search_result){
		$recommend_array=array();
		// if(empty($items_search_result)){

		// }
		$items=query_yelp_api("bars","San Francisco, CA");
		// echo $items[0]['name'];
		// echo $items[0]['url'];
		// echo $items[0]['rating'];
		// echo $items[0]['location'];

	}
	function recommend_system($connection,$items_search_result){

		$recommended_result = mysqli_query($connection, "SELECT * FROM Product ");
		$avg_item=array();
		$items_recommend = array();
		//if cannot find similar items, simply generate a random vector
		if (empty($items_search_result)){
			for ($i = 0; $i < 23; $i++){
				array_push($avg_item,0);
			}
		}
		else
		 	 $avg_item=generate_average_item($items_search_result);

		while($row = mysqli_fetch_assoc($recommended_result)){

			$search_item=array();
			$recommended_item = array();
			$search_item['Type']=$row['Type'];
		    $search_item['Taste']=$row['Taste'];
		    $search_item['Nutrition']=$row['Nutrition'];
		    $search_item['Price']=$row['Price'];
		    $similarity_score=similarity_score($avg_item,$search_item);
			$recommended_item['img'] = '<div class=\"user-info\"><img src="data:image/jpeg;base64,' . base64_encode($row['image']). '" class="item-img"  width="130px" height="60px" /><br />';
			$recommended_item['item_name'] = "<b>Item: " ."&nbsp;&nbsp;&nbsp;</b>". $row['item_name'];
			$recommended_item['Type'] = "<b>Type: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Type'];
			$recommended_item['Taste'] = "<b>Taste: " ."&nbsp;&nbsp;&nbsp;</b>" . $row['Taste'];
			$recommended_item['Nutrition']= "<b>Nutrition Info: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Nutrition'];
		    $recommended_item['Price'] = "<b>Price: " ."&nbsp;&nbsp;&nbsp;</b>". "$". $row['Price'];
			$recommended_item['sim_score']=$similarity_score;
			$user = $row['Username'];	
            $temp1 = mysqli_query($connection, "SELECT LastLogIn FROM User where Username='$user'");
			$temp2 =mysqli_query($connection, "SELECT LastLogOut FROM User where Username='$user'");	

            
			 while ($row = mysqli_fetch_assoc($temp1)) {
   				 $lastLogin = $row['LastLogIn'];
   				 break;
				 } 

				 while ($row2 = mysqli_fetch_assoc($temp2)) {
   				 $lastLogOut = $row2['LastLogOut'];
   				 break;
				 } 

			if ($lastLogin > $lastLogOut )
				$recommended_item['chat'] =  '<button onclick="chat(\'' . $user . '\')">Chat</button>';
			else
				$recommended_item['chat'] = "";
		    $recommended_item['order-item'] = $row['item_name'];
		    $recommended_item['order-seller'] = $row['Username'];
		    array_push($items_recommend, $recommended_item);

		}

		$score = array();
		for ($i=0;$i<sizeof($items_recommend);$i++){
		    $score[$i] = $items_recommend[$i]['sim_score'];
		}
		array_multisort($score, SORT_DESC, $items_recommend);
		return $items_recommend;


	}
	//find the average of search result
	function generate_average_item($search_result=array()){
		$avg_item=array();
		$type_array=array();
		$taste_array=array();
		$nutrition_array=array();
		$price_array=array();

		if(!empty($search_result)){
			for ($i = 0; $i < sizeof($search_result); $i++){
				array_push($type_array,$search_result[$i]['Type']);
				array_push($taste_array,$search_result[$i]['Taste']);
				array_push($nutrition_array,$search_result[$i]['Nutrition']);
				array_push($price_array,$search_result[$i]['Price']);

			}
		}
		$c = array_count_values($type_array); 
		$max_type = array_search(max($c), $c);
		$d = array_count_values($taste_array); 
		$max_taste = array_search(max($d), $d);
		$avg_nutrition = array_sum($nutrition_array) / count($nutrition_array); 
		$avg_price = array_sum($price_array) / count($price_array);
		$avg_item['Type']=$max_type;
	    $avg_item['Taste']=$max_taste;
	    $avg_item['Nutrition']=$avg_nutrition;
	    $avg_item['Price']=$avg_price; 
		return $avg_item;

	}


	function dotp($arr1, $arr2){
     return array_sum(array_map(create_function('$a, $b', 'return $a * $b;'), $arr1, $arr2));
	}

	function similarity_score($item1,$item2){
		$vector1=array();
		$vector2=array();
		$vector1=array_merge(type_feature($item1),Taste_feature($item1),Nutrition_feature($item1),Price_feature($item1));
		$vector2=array_merge(type_feature($item2),Taste_feature($item2),Nutrition_feature($item2),Price_feature($item2));
		$similarity=dotp($vector1,$vector2)/sqrt(dotp($vector1,$vector1)*dotp($vector2,$vector2));
		return $similarity;
	}
	function type_feature($item){
		$ret=array();
		if($item['Type']=="" || $item['Type']=="Other"){
			array_push($ret,0,0,0,0,0,1);
		}
		elseif ($item['Type']=="Snacks/Appetizers"){
			array_push($ret,1,0,0,0,0,0);
		}
		elseif ($item['Type']=="Entrees"){
			array_push($ret,0,1,0,0,0,0);
		}
		elseif ($item['Type']=="Salads"){
			array_push($ret,0,0,1,0,0,0);
		}
		elseif ($item['Type']=="Burgers/Sandwiches"){
			array_push($ret,0,0,0,1,0,0);
		}
		elseif ($item['Type']=="Drinks"){
			array_push($ret,0,0,0,0,1,0);
		}
		else{
			array_push($ret,0,0,0,0,0,0);
		}
		return $ret;
	}
	function Taste_feature($item){
		$ret=array();
		if($item['Taste']=="" || $item['Taste']=="Other"){
			array_push($ret,0,0,0,0,0,1);
		}
		elseif ($item['Taste']=="Sweet"){
			array_push($ret,1,1,0,0,0,0);
		}
		elseif ($item['Taste']=="Sweet/Sour"){
			array_push($ret,1,1,0,0,0,0);
		}
		elseif ($item['Taste']=="Salty"){
			array_push($ret,0,0,1,0,0,0);
		}
		elseif ($item['Taste']=="Spicy"){
			array_push($ret,0,0,0,1,0,0);
		}
		elseif ($item['Taste']=="Bitter"){
			array_push($ret,0,0,0,0,1,0);
		}
		else{
			array_push($ret,0,0,0,0,0,0);
		}
		return $ret;
	}
	function Nutrition_feature($item){
		$ret=array();
		$nutrition=$item['Nutrition'];
		if($nutrition>=0 and $nutrition<200){
			array_push($ret,1,1,0,0,0,0);
		}
		elseif ($nutrition>=200 and $nutrition<400){
			array_push($ret,1,1,1,0,0,0);
		}
		elseif ($nutrition>=400 and $nutrition<600){
			array_push($ret,0,1,1,1,0,0);
		}
		elseif ($nutrition>=600 and $nutrition<800){
			array_push($ret,0,0,1,1,1,0);
		}
		elseif ($nutrition>=800 and $nutrition<1000){
			array_push($ret,0,0,0,1,1,1);
		}
		elseif ($nutrition>=1000){
			array_push($ret,0,0,0,0,1,1);
		}
		else{
			array_push($ret,0,0,0,0,0,0);
		}
		return $ret;
	}

	function Price_feature($item){
		$ret=array();
		$price=$item['Price'];
		if($price>=0 and $price<20){
			array_push($ret,1,0,0,0,-1);
		}
		elseif ($price>=20 and $price<40){
			array_push($ret,1,1,0,0,0);
		}
		elseif ($price>=40 and $price<60){
			array_push($ret,0,1,1,1,0);
		}
		elseif ($price>=60){
			array_push($ret,0,0,0,1,1);
		}
		else{
			array_push($ret,0,0,0,0,0);
		}
		return $ret;
	}

	function isOnline($user, $connection){
		$lastLogin = mysqli_query($connection, "SELECT LastLogIn FROM User where Username='$user'");
		$lastLogout = mysqli_query($connection, "SELECT LastLogOut FROM User where Username='$user'");
	/*	$_SESSION['login'] = $lastLogin;
		$_SESSION['logout'] = $lastLogout;
*/
		if ($lastLogin > $lastLogout) 
			return true;
		else
			return false;
	}		 	
  	        

function display_item($iteminfo=array()){
   $res = "";
   if (!empty($iteminfo)){ 
   	for ($i = 0; $i < sizeof($iteminfo); $i++){
   	   $curr = array();
   	 $res .= $iteminfo[$i]['img'];
     $res .=$iteminfo[$i]['item_name'] . "<br />";
	$res .=$iteminfo[$i]['Type'] . "<br />" ;
     $res .=$iteminfo[$i]['Taste'] . "<br />"; 
     $res .=$iteminfo[$i]['Ready_time'] . "<br />";
     $res .=$iteminfo[$i]['Nutrition'] . "<br />";
     $res .=$iteminfo[$i]['Price'] . "<br />";
     $res .=$iteminfo[$i]['Date'] . "<br />";
     $res .=$iteminfo[$i]['Seller'];
     $res .= "&nbsp;&nbsp;". $iteminfo[$i]['chat']  ."<br />";

     // http://stackoverflow.com/questions/6502107/how-to-pass-php-array-parameter-to-javascript-function
    /*
     array_push($curr, $iteminfo[$i]['order-item'], $iteminfo[$i]['order-seller'], $_SESSION['name']);
     $Details = implode(",", $curr);

     $res .= '<button id="order-item" onclick="order_item(\'' . $Details . '\')">ORDER</button><br />';
     */
     $res .= $iteminfo[$i]['Order'];
     $res .= "<hr />";
     $res .= "</div>";
     $res .= "<br /><br />";

    }
   }  

   return $res;
  }		

  function display_recommend_item($userinfo=array()){
   $output = "";
   if (!empty($userinfo)){ 
   	for ($i = 0; $i < sizeof($userinfo); $i++){
   	   $curItem = array();
   	 $output .= $userinfo[$i]['img'];
     $output .=$userinfo[$i]['item_name'] . "<br />";
	$output .=$userinfo[$i]['Type'] . "<br />" ;
     $output .=$userinfo[$i]['Taste'] . "<br />"; 
     $output .=$userinfo[$i]['Nutrition'] . "<br />";
     $output .=$userinfo[$i]['Price'] . "<br />";
      $output .=$userinfo[$i]['sim_score'];

     // http://stackoverflow.com/questions/6502107/how-to-pass-php-array-parameter-to-javascript-function
     array_push($curItem, $userinfo[$i]['order-item'], $userinfo[$i]['order-seller'], $_SESSION['name']);
     $Order = implode(",", $curItem);

     $output .= '<button id="order-item" onclick="order_item(\'' . $Order . '\')">ORDER</button><br />';
     $output .= "<hr />";
     $output .= "</div>";
     $output .= "<br /><br />";

    }
   }  
   
   return $output;
  }		

?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Results</title>
	<!--fonts-->
	    <link href='https://fonts.googleapis.com/css?family=Lato:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
		
	<!--//fonts-->
			<link href="css/bootstrap.css" rel="stylesheet">
			<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- for-mobile-apps -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Favorites Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
		Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- //for-mobile-apps -->	
	<!-- js -->
		<script type="text/javascript" src="js/jquery.min.js"></script>
	<!-- js -->
	<!-- cart -->
		<script src="js/simpleCart.min.js"> </script>
	<!-- cart -->
	<!-- start-smoth-scrolling -->
		<script type="text/javascript" src="js/move-top.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});

                var User = "<?php echo $_SESSION['name']; ?>";
              /*  var login = "<?php echo $_SESSION['login']; ?>"
                var logout = "<?php echo $_SESSION['logout']; ?>"
                alert(login);
                alert(logout); */
				if (!User){
					var content1 = "<ul><li id=\"login_link\"><a href=\"login.php\">Login</a></li>";
					    content1 += " | ";
						content1 += "<li id=\"register_link\"><a href=\"register.php\">Register</a></li></ul>";
					$(".login-section").html(content1);
				}
				else {
					var content2 = "<ul><li id=\"logout_link\">";
						content2 += "<form action=\"logout.php\" method=\"post\">";
						content2 += "<input type=\"submit\" name=\"submit\" value=\"Sign Out\" id=\"logoutbutton\" />";
						content2　+= " | ";
						content2 += "<a href=\"user.php\">My Homepage</a>";
						content2 += "</form></li></ul>";
					$(".login-section").html(content2);
				}
				
			});
          /*
	         window.onbeforeunload = function(){
	         	return "Refreshing the page will erase the results from your last query. Please start a new search.";
	         }
	         */
	         function chat(seller){
	         	var curUser = "<?php echo $_SESSION['name'] ;?>";
	         	var url = 'chat.php?user1=' + curUser + "&user2=" + seller; // initiator first, responder second

	         	if (seller && curUser){
	         		$.ajax({
						url: "chat-requests.php",
						type: "get", 
						data:{initiator: curUser, responder: seller, URL: url},
						  success: function(response) {
							window.location = url;
						},
						  error: function(xhr) {
						    console.log("Failed to send chat request.");
						  }
						});
		         	}
	         }

	          function order_item(info){
           	   //alert(item);
           	 // alert('Delete called!');
           	  var order_info = info.split(',');
           	  console.log(order_info);
           	  var item = order_info[0];
           	  var seller = order_info[1];
           	  var buyer = order_info[2];
              var message = prompt("Leave a message to the seller regarding this order (optional): ");

              console.log("item: " + item);
              console.log("seller: " + seller);
              console.log("buyer: " + buyer);
              console.log("message: " + message);
           	   
           	   var target = item;
               $.ajax({
                   url: 'place-order.php',
                   data: {Item: item, Seller: seller, Buyer: buyer, Notes: message},
                   type: 'POST',
                   success: function(response){
                   	 // alert('Your order has been placed successfully. Thank you.');
                   	 console.log(response);
                   },
 		  		   error: function(){
 		  		   	   console.log("Can't place order.");
 		  		   } 
               });
			  
           }
		</script>
</head>
<body>
<!-- header -->
<div class="header">
	<div class="container">
		<div class="top-header">
				<div class="header-left">
					<!--<p>Place your order and get 20% off on each price</p>-->
				</div>
				<div class="login-section">
					<ul>
						<li><a href="login.php">Login</a>  </li> |
						<li><a href="register.php">Register</a> </li>
					</ul>
				</div>
				<!-- start search-->
				    <div class="search-box">
					    <div id="sb-search" class="sb-search">
							<form action="results.php" method="post">
								<input class="sb-search-input" placeholder="Enter your search item..." type="search" name="search" id="search">
								<input class="sb-search-submit" type="submit" value="">
								<span class="sb-icon-search"> </span>
							</form>
						</div>
				    </div>
					<!-- search-scripts -->
					<script src="js/classie.js"></script>
					<script src="js/uisearch.js"></script>
						<script>
							new UISearch( document.getElementById( 'sb-search' ) );
						</script>
				<!-- //search-scripts -->
				<div class="header-right">
					<!--
						<div class="cart box_1">
							<a href="checkout.html">
								<h3> <span class="simpleCart_total"> $0.00 </span> (<span id="simpleCart_quantity" class="simpleCart_quantity"> 0 </span> items)<img src="images/bag.png" alt=""></h3>
							</a>	
							<p><a href="javascript:;" class="simpleCart_empty">Empty cart</a></p>
							<div class="clearfix"> </div>
						</div>
					-->
				</div>
				<div class="clearfix"></div>
		</div>
	</div>
</div>

<!-- //header -->
<!-- banner -->
<div class="banner-slider">
	<div class="banner-pos">
					<div class="banner one page-head">
						<div class="container">
							<div class="navigation text-center">
								<span class="menu"><img src="images/menu.png" alt=""/></span>
									<ul class="nav1">
										<li><a href="index.php">HOME</a></li>
										<li><a href="#">ABOUT</a></li>
										<li><a href="#">MENU</a></li>
										<li><a href="#">GALLERY</a></li>
										<li><a href="#">TODAY'S SPECIAL</a>
										<li><a href="#">CONTACT</a></li>
										<div class="clearfix"></div>
									</ul>
									<!-- script for menu -->
										<script> 
											$( "span.menu" ).click(function() {
											$( "ul.nav1" ).slideToggle( 300, function() {
											 // Animation complete.
											});
											});
										</script>
									<!-- //script for menu -->

							</div>
							<!-- point burst circle -->
							<div class="logo">
								<a href="index.php">
									<div class="burst-36 ">
									   <div>
											<div><span><img src="images/logo.png" alt=""/></span></div>
									   </div>
									</div>
									<div align="center">
									<h1>EATIT</h1>
								</div>
								</a>
							</div>
							<!-- //point burst circle -->
							
						</div>
					</div>
	</div>
</div>

<!-- //banner -->
<!-- login-page -->
<div class="login">
	<div class="container">
		<div class="login-grids">
			<div class="row">
				<!-- <p ><?php echo query_yelp_api("bars","San Francisco, CA"); ?> </p><br /> -->
				<h3 id="message"><?php echo $_SESSION['h3']; ?> </h3><br />
					<div class="col-sm-9 col-md-9 col-lg-9">
			   <?php echo display_item($items); 
			    $_SESSION['queryString'] = "";
			    /* $_POST['search'] = "";
			     $_SESSION["h3"] = ""; */
			   ?>
				</div>
				<div class="col-sm-3 col-md-3 col-lg-3">
					<h4 id="message">Items you might interested in<br/></h3>
							<?php echo display_recommend_item($items_recommend); 
				    $_SESSION['queryString'] = "";
				    /* $_POST['search'] = "";
				     $_SESSION["h3"] = ""; */
				   ?>
				</div>
			</div>
			
		 

			<div class="clearfix"></div>
		</div>
	</div>
			
</div>
<!-- //footer-top -->
<!-- footer -->
<div class="footer">
	<div class="container">
		<div class="footer-left">
			<p>Copyright &copy; 2016 Eatit</p>
		</div>
		
		<div class="footer-right">
			<ul>
			   <li>Yiwei Zhuang<li>
			   <li>Daocun Yang<li>
			   	<li>Yang Yao<li>
			   <li>Yang Song<li>		
			</ul>
		</div>
	
		<div class="clearfix"></div>
	</div>
</div>
<!-- //footer -->
<!-- smooth scrolling -->
	
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- //smooth scrolling -->

</body>
</html>