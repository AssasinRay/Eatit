<?php 
  
    session_start();
if (isset($_POST['search'])){
     $_SESSION['queryString'] = $_POST['search'];
     //echo $_SESSION['queryString'];
     header('Location: results.php');
}

require "lib/password.php";

if (isset($_POST['submit'])){
	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$password="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $password);
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

	if (isset($_POST['username']) && isset($_POST['password'])){
         $username = mysqli_real_escape_string($connection, $_POST['username']);
		 $inputpin = $_POST['password'];
         
         $result = mysqli_query($connection, "SELECT * FROM User where Username='$username'");
		 $get_rows= mysqli_affected_rows($connection);

		 if($get_rows != 0){
			while($row = mysqli_fetch_assoc($result)){
				$dbusername = $row['Username'];
				$dbpin = $row['password'];
			}

			//if ($dbpin != $inputpin)
			if (password_verify($inputpin, $dbpin) == false)	
			   $errors['combination'] = "Please double check your username/password";
			else {
				$_SESSION['name'] = $username;
				// update the last login timestamp:
               
                $curTime = time();
                $updateTime = "UPDATE User SET LastLogIn='$curTime' where Username='$username' ";
                
                //$updateTime = "UPDATE User SET LastLogIn= now() where Username='$username' ";
		        $res = mysqli_query($connection,$updateTime);

		        header('Location: user.php');
		       /* ?><script>window.location = "user.php";</script><?php */
				/*?> 
				<script type="text/javascript"> 
				var name = "<?php echo $dbusername ?>";
				sessionStorage.User = name;
				//alert(sessionStorage.User);
				window.location = "user.php";
				</script>
				<?php
				*/
			//	$_SESSION['name'] = $username;
			//	header('Location: user.php');
			}
		 }
		 else
		 	$errors['notfound'] = "User not found";

	}
    else 
    	$errors['missing'] = "All fields are required";
}

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
	<title>Login</title>
	<!--fonts-->
		    <link href='https://fonts.googleapis.com/css?family=Lato:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
		
	<!--//fonts-->
			<link href="css/bootstrap.css" rel="stylesheet">
			<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- for-mobile-apps -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="Eatit - food sharing platform for Champaign, Illinois">
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
				/*
				$("#loginbutton").click(function(){
					sessionStorage.User = $('#username').val();
				});
*/
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
							<form action="login.php" method="post">
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
			<div class="col-md-6 log">
					 <h3>LOGIN</h3>
					 <div class="strip"></div>
					 <p>Welcome, please log in to continue.</p>
					 <form action="login.php" method="post">
						 <h5>User Name:</h5>	
						 <input type="text" id="username" name="username" placeholder="username">
						 <h5>Password:</h5>
						 <input type="password" id="password" name="password" placeholder="password">					
						 <p id="login_error">
						 	<?php echo display_errors($errors); ?>
						 </p>
						 <input id="loginbutton"type="submit" name="submit" value="LOGIN">

					 </form>
					 <!--
					<a href="#">Forgot Password ?</a>
				-->
			</div>
			<div class="col-md-6 login-right">
					<h3>NEW REGISTRATION</h3>
					<div class="strip"></div>
					<p>By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
					<a href="register.php" class="hvr-shutter-in-horizontal button">CREATE AN ACCOUNT</a>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>

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