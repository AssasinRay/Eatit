<?php 
   session_start();
   if (!$_SESSION['name'])
   		header('Location: index.php');

$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
	$errors = array();

	if (!$connection){
	    die("Database Connection Failed" . mysqli_connect_error());
	}

	$select_db = mysqli_select_db($connection,$database_name);

	if (!$select_db){
	    die("Database Selection Failed" . mysql_error());
	}

    if (isset($_POST['itemname']) && isset($_POST['type'])  && isset($_POST['time'])
      			&& isset($_POST['nutri-info'])  && isset($_POST['price']))
    {
        $username = $_SESSION['name'];
        $itemname = mysqli_real_escape_string($connection, $_POST['itemname']);
		$type = mysqli_real_escape_string($connection, $_POST['type']);
        $time = mysqli_real_escape_string($connection, $_POST['time']);
        $nutrition = mysqli_real_escape_string($connection, $_POST['nutri-info']);
		$price = mysqli_real_escape_string($connection, $_POST['price']);

        $file = $_FILES['image-upload']['tmp_name'];

			$mysql_get_users = mysqli_query($connection, "SELECT * FROM Product where Username='$username' AND item_name='$itemname'");
			$get_rows = mysqli_affected_rows($connection);

			if($get_rows >=1){
				array_push($errors, "You already have an item that named ". "$itemname");
			}
			

            if (!ctype_alpha($type)) {
            	array_push($errors, "Please enter a valid item type (e.g. food, drink, etc)");
            }
            	
            if (!is_numeric($time) || $time < 0)
            	array_push($errors,"Please enter a valid number for preparation time");

            if (!is_numeric($price) || $price < 0)
            	array_push($errors, "Please enter a valid price");
  
            if (!isset($file))
                array_push($errors, "Please upload an image of your item");

            $image = addslashes(file_get_contents($file));
            $image_size = getimagesize($file);
            // check to make sure it's an image, not a file of other types like text document
            if (!$image_size)
            	array_push($errors, "Please upload a valid image of your item");

            if (empty($errors)) {

	            $query = "INSERT INTO Product (Username, item_name, Type, Ready_time, Nutrition, image, Price) 
	 			VALUES ('$username', '$itemname', '$type', '$time', '$nutrition', '$image', '$price')";

		        $result = mysqli_query($connection,$query);
		        if(!$result){
		        	die("Database error: " . mysqli_error($connection));
		        }
            }
 			
    }
    else 
    	array_push($errors, "All fields are required");


   function display_errors($errors=array()){
   $output = "";
   if (!empty($errors)){ 
     foreach ($errors as $error){
    	$output .= "$error <br />";
     }
   }
   return $output;
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<!--fonts-->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
		<link href='css/fonts.css' rel='stylesheet' type='text/css'>
		
	<!--//fonts-->
			<link href="css/bootstrap.css" rel="stylesheet">
			
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

				//$("#Name").text(sessionStorage.User);
                var add_form = $('#item-form');
                var outer = $('.registration-form');

				//$("#Name").text(sessionStorage.User);

				$("#logout_link").click(function(){
					sessionStorage.clear();
				});

				$('#add-item-button').click(function(){
					add_form.toggle(300);
				});
			});
		</script>
	<!-- start-smoth-scrolling -->

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
						<li id="logout_link">
						<form action="logout.php" method="post">
							<input type="submit" name="submit" value="Sign Out" id="logoutbutton"/>
							<a href="myprofile.php">My Profile</a>
						</form>
						</li>
					</ul>
				</div>
				<!-- start search-->
				    <div class="search-box">
					    <div id="sb-search" class="sb-search">
							<form>
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
<!-- registration-form -->

<div class="registration-form">
	<div class="container">
		    <h3>Welcome, 
		    	<!--<span id="Name"></span>-->
		    	<?php echo $_SESSION['name']; ?>
		    </h3><br /><br />
      
      <div id="buttons" align="center">
     		<a class="hvr-shutter-in-horizontal button" id="add-item-button">ADD NEW ITEM</a>
     		<a class="hvr-shutter-in-horizontal button" style="margin-left:1%">MY ITEMS</a>
     		<a class="hvr-shutter-in-horizontal button" style="margin-left:1%">MY ORDERS</a>
  		</div>
		
		<div id="item-form">
			<div class="reg-form">
				<div class="reg">
					 <p>Please enter the following information for the new item you plan to sell.</p>
					 <o>Having added the item successfully, the item will show up upon clicking the "MY ITEMS" button above.</p>
					 <form action="user.php" method="post" enctype="multipart/form-data">
						 <ul>
							 <li class="text-info">Name: </li>
							 <li><input type="text" id="username "name="itemname" placeholder="name of the item"></li>
						 </ul>
						<ul>
							 <li class="text-info">Type: </li>
							 <li><input type="text" id="email "name="type" placeholder="type of the item (e.g. food, drink, etc.)"></li>
						</ul>
						<ul>
							 <li class="text-info">Preparation Time: </li>
							 <li><input type="text" id="email "name="time" placeholder="can be made in _____ minutes?"></li>
						 </ul>
						 <ul>
							 <li class="text-info">Nutrition info: </li>
							 <li><input type="text" id="email "name="nutri-info" placeholder="notes on nutrition, allergens, etc."></li>
						 </ul>
						  <ul>
							 <li class="text-info">Price: </li>
							 <li><input type="text" id="email "name="price" placeholder="without the dollar sign"></li>
						 </ul>
								
								<ul>
									<li class="text-info">Select an image to upload: </li>
									<li><input type="file" id="image-upload" name="image-upload" ></li>
								</ul>
						 <p id="signup_error">
						 	<?php echo display_errors($errors); 
                            
                             if ($errors[0] !== "All fields are required"){
                                ?><script>confirm("Error(s) detected in your input. \nPlease fill out the form again.");</script><?php 
                            }
						 	?>
						 </p>
						 <div align="center" style="margin-top:2%">
						 <input type="submit" name="submit" value="CREATE">
						</div>
						 <!--
						 <p class="click">By clicking this button, you are agree to my  <a href="#">Policy Terms and Conditions.</a></p> 
						-->
					 </form>
				 </div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<!--
<div class="registration-form">
	<div class="container">
      <h3>Welcome, <span id="Name"></span></h3><br /><br />
      <div id="buttons" align="center">
     		<a class="hvr-shutter-in-horizontal button" id="add-item-button">Add New Item</a>
     		<a class="hvr-shutter-in-horizontal button" style="margin-left:1%">Display My Items</a>
  		</div>
  		<div class="registration-grids">
  		<div id="item_form" align="center">
     
     						 <p>Please enter the following information for the new item you plan to sell</p>
					 <<form action="login.php" method="post">
						 <h5>User Name:</h5>	
						 <input type="text" id="username" name="username" placeholder="username">
						 <h5>Password:</h5>
						 <input type="password" id="password" name="password" placeholder="password">					
						 <p id="login_error">
						 </p>
						 <input id="loginbutton"type="submit" name="submit" value="LOGIN">

					 </form>
    
			</div>
	</div>
	<div class="clearfix"></div>
	</div>
</div>
<div id="item_form">
     
     						 <p>Welcome, please log in to continue.</p>
					 <form action="" method="post">
						 <h5>User Name:</h5>	
						 <input type="text" id="username" name="username" placeholder="username">
						 <h5>Password:</h5>
						 <input type="password" id="password" name="password" placeholder="password">					
						 <p id="login_error">
						 	
						 </p>
						 <input id="loginbutton"type="submit" name="submit" value="LOGIN">

					 </form>
    
			
	</div>
-->
<!-- registration-form -->

<!-- footer-top -->
<!--
<div class="footer-top">
	<div class="container">
		<div class="col-md-3 footer-grid">
			<h3><a href="#">FAVORITES</a></h3>
		</div>
		<div class="col-md-3 footer-grid">
			<h4>BUFFET</h4>
			<p>MONDAY - THURSDAY<span>7 : 00 - 21 : 00</span></p>
		</div>
		<div class="col-md-3 footer-grid">
			<h4>ORDERS</h4>
			<p>MONDAY - SUNDAY<span>7 : 00 - 21 : 00</span></p>
		</div>
		<div class="col-md-3 footer-grid">
			<h4>ADDRESS</h4>
			<ul>
				<li class="list-one">Lorem ipsy street, Newyork</li>
				<li class="list-two"><a href="mailto:info@example.com">favorites@example.com</a></li>
				<li class="list-three">+8 800 555 555 55</li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
-->
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
	<script type="text/javascript">
		$(document).ready(function() {
		/*
			var defaults = {
			containerID: 'toTop', // fading element id
			containerHoverID: 'toTopHover', // fading element hover id
			scrollSpeed: 1200,
			easingType: 'linear' 
			};
		*/								
		$().UItoTop({ easingType: 'easeOutQuart' });
		});
	</script>
	<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- //smooth scrolling -->

</body>
</html>