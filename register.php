<?php
	// require('dbconnect.php');

	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
	$errors = array();

	if (!$connection){
		// <script> alert('connection fail')</script>
	    die("Database Connection Failed" . mysqli_connect_error());
	}

	$select_db = mysqli_select_db($connection,$database_name);

	if (!$select_db){
		// <script> alert('databaseselection fail')</script>
	    die("Database Selection Failed" . mysql_error());
	}

    if (isset($_POST['username']) && isset($_POST['password'])  && isset($_POST['repassword'])
      			&& isset($_POST['email'])  && isset($_POST['address']) && isset($_POST['phonenumber']))
    {
    	//echo "all fields are set";

        $username = mysqli_real_escape_string($connection, $_POST['username']);
		$email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $repassword = mysqli_real_escape_string($connection, $_POST['repassword']);
		$address = mysqli_real_escape_string($connection, $_POST['address']);
        $phonenumber = mysqli_real_escape_string($connection, $_POST['phonenumber']);

			$mysql_get_users = mysqli_query($connection, "SELECT * FROM User where Username='$username'");
			$get_rows = mysqli_affected_rows($connection);
			if($get_rows >=1){
				$errors['username'] = "Username already exists. Please try another name";
			}

            $validate_email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$validate_email) {
            	$errors['email'] = "Please enter a valid email";
            }
            	
			$mysql_get_emails = mysqli_query($connection, "SELECT * FROM User where email='$email'");
			$get_rows2 = mysqli_affected_rows($connection);
			if($get_rows2 >=1){
				$errors['email'] = "Email has been taken. Please use another email address";
			}

            if ($password!=$repassword) 
            	$errors['password'] = "Passwords do not match";

            if (empty($errors)) {
	            $query = "INSERT INTO User (Username, PASSWORD, phone_num,address, email) 
	 			VALUES ('$username', '$password', '$phonenumber', '$address', '$email')";
	//  			$query="INSERT INTO User( Username, 
	// PASSWORD , phone_num, address, email ) 
	// VALUES (
	// 'newname',  's1sss23123',  '123123',  'asdfasdf',  'a@a.a'
	// )";
		        $result = mysqli_query($connection,$query);
		        if($result){
		        //	echo "user create successfully";
		            $msg = "User Created Successfully.";
		            // redirect to login page here
		            header('Location: login.php');
		        }
		        else
		        {
		        	die("Database error: " . mysqli_error($connection));
		        }
            }
 			
    }
    else 
    	$errors['missing'] = "All fields are required";


   function display_errors($errors=array()){
   $output = "";
   if (!empty($errors)){ 
     foreach ($errors as $key => $error){
    	$output .= "{$error}<br />";
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
		<link href='css/fonts.css' rel='stylesheet' type='text/css'>
		
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
				//$('#regerror').text("");
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
				/*
				$('#repassword').blur(function(){
					var pin = $('#password').val();
					var repin = $('#repassword').val();
					if (pin !== repin) 
						$('#regerror').text("*Your password doesn't match");
					else 
						$('#regerror').text("");
				}); */
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
						<li><a href="login.php">Login</a>  </li> |
						<li><a href="register.php">Register</a> </li>
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
		<h3>Registration</h3>
		<div class="strip"></div>
		<div class="registration-grids">
			<div class="reg-form">
				<div class="reg">
					 <p>Welcome, please enter the following details to continue.</p>
					 <p>If you have previously registered with us, <a href="login.php">click here</a>.</p>
					 <p>Upon successful registration, you will be redirected to the login page.</p>
					 <form action="register.php" method="post">
						 <ul>
							 <li class="text-info">Username: </li>
							 <li><input type="text" id="username "name="username" placeholder="username"></li>
						 </ul>
						<ul>
							 <li class="text-info">Email: </li>
							 <li><input type="text" id="email "name="email" placeholder="email"></li>
						 </ul>
						 <ul>
							 <li class="text-info">Password: </li>
							 <li><input type="password" id="password" name="password" placeholder="password"></li>
						 </ul>
						 <ul>
							 <li class="text-info">Re-enter Password:</li>
							 <li><input type="password" id="repassword" name="repassword" placeholder="password again"></li>
						 </ul>
						 <ul>
							 <li class="text-info">Phone Number:</li>
							 <li><input type="text" id="phonenumber" name="phonenumber" placeholder="phonenumber"></li>
						 </ul>	
						  <ul>
							 <li class="text-info">Address:</li>
							 <li><input type="text" id="address" name="address" placeholder="address"></li>
						 </ul>								
						 <p id="signup_error">
						 	<?php echo display_errors($errors); ?>
						 </p>
						 <input id="regbutton"type="submit" name="submit" value="REGISTER NOW">
						 <!--
						 <p class="click">By clicking this button, you are agree to my  <a href="#">Policy Terms and Conditions.</a></p> 
						-->
					 </form>
				 </div>
			</div>
			<!--
			<div class="reg-right">
				 <h3>Completely Free Account</h3>
				 <div class="strip"></div>
				 <p>Pellentesque neque leo, dictum sit amet accumsan non, dignissim ac mauris. Mauris rhoncus, lectus tincidunt tempus aliquam, odio 
				 libero tincidunt metus, sed euismod elit enim ut mi. Nulla porttitor et dolor sed condimentum. Praesent porttitor lorem dui, in pulvinar enim rhoncus vitae. Curabitur tincidunt, turpis ac lobortis hendrerit, ex elit vestibulum est, at faucibus erat ligula non neque.</p>
				 <h3 class="lorem">Lorem ipsum dolor.</h3>
				 <div class="strip"></div>
				 <p>Tincidunt metus, sed euismod elit enim ut mi. Nulla porttitor et dolor sed condimentum. Praesent porttitor lorem dui, in pulvinar enim rhoncus vitae. Curabitur tincidunt, turpis ac lobortis hendrerit, ex elit vestibulum est, at faucibus erat ligula non neque.</p>
			</div>
		-->
			<div class="clearfix"></div>
		</div>
	</div>
</div>
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
