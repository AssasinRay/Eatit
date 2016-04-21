<?php
	// require('dbconnect.php');
    session_start();

       if (!$_SESSION['name'])
   		header('Location: index.php');

if (isset($_POST['search'])){
     $_SESSION['queryString'] = $_POST['search'];
     //echo $_SESSION['queryString'];
     header('Location: results.php');
}


if (isset($_POST['submit'])){

	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
	$error = array();

	if (!$connection){
		// <script> alert('connection fail')</script>
	    die("Database Connection Failed" . mysqli_connect_error());
	}

	$select_db = mysqli_select_db($connection,$database_name);

	if (!$select_db){
		// <script> alert('databaseselection fail')</script>
	    die("Database Selection Failed" . mysql_error());
	}
            $username = $_SESSION['name'];
           // echo $username;
	if (isset($_POST['email'])){
			$newemail = mysqli_real_escape_string($connection, $_POST['email']);

		 	$validate_email = filter_var($newemail, FILTER_VALIDATE_EMAIL);
            if (!$validate_email) {
            	$errors['email'] = "Please enter a valid email";
            }
            else
            {
				 $query = "UPDATE User SET email='$newemail' where Username='$username' ";
		        $result = mysqli_query($connection,$query);
		        if($result){
		        //	echo "user create successfully";
		            $msg = "User Created Successfully.";
		            // redirect to login page here
		            header('Location: myprofile.php');
		        }
		        else
		        {
		        	die("Database error: " . mysqli_error($connection));
		        }
		    }

		 }
    else 
    	$errors['missing'] = "Please enter your new email";
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
	<title>Register</title>
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
							<input type="submit" name="submit" value="Sign Out" id="logoutbutton"/> | 
							<a href="user.php">My Homepage</a>
						</form>
						</li>
					</ul>
				</div>
				<!-- start search-->
				    <div class="search-box">
						<div id="sb-search" class="sb-search">
							<form action="changeemail.php" method="post">
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
<!-- registration-form -->

<div class="registration-form">
	<div class="container">
		<div id="profile-info">
			<div class="reg-form">
				<div class="reg">
					 <h3>Update email address: </h3><br /><br />
											
						 <form action="changeemail.php" method="post">
						 <ul>
							 <li class="text-info">New Email: </li>
							 <li><input type="email" id="email" name="email" placeholder="Enter your new email"></li>
						 </ul>			
						 <p id="login_error">
						 	<?php echo display_errors($errors); ?>
						 </p>
						 <input id="loginbutton"type="submit" name="submit" value="UPDATE">

					 </form>

						 
					 
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