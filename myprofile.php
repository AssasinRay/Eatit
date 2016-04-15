<?php
    session_start();

   if (!$_SESSION['name'])
   		header('Location: index.php');
   	
if (isset($_POST['search'])){
     $_SESSION['queryString'] = $_POST['search'];
     //echo $_SESSION['queryString'];
     header('Location: results.php');
}


	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
	$userinfo = array();

	if (!$connection){

	    die("Database Connection Failed" . mysqli_connect_error());
	}

	$select_db = mysqli_select_db($connection,$database_name);

	if (!$select_db){

	    die("Database Selection Failed" . mysql_error());
	}
            $username = $_SESSION['name'];
           // echo $username;
			$result = mysqli_query($connection, "SELECT * FROM User where Username='$username'");

			while($row = mysqli_fetch_assoc($result)){
  		 	   	$length=strlen($row['password']);
				$userinfo['dbusername'] = "<div class=\"user-info\"><b>Username: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Username'];
				$pin = "";
				for ($i=0; $i<$length; $i++)
					$pin.="*";
				$userinfo['pin'] = "<b>Password: " ."&nbsp;&nbsp;&nbsp;</b>". $pin;
				$userinfo['phone'] = "<b>Phone: " ."&nbsp;&nbsp;&nbsp;</b>" . $row['phone_num'];
				$userinfo['addr'] = "<b>Address: " ."&nbsp;&nbsp;&nbsp;</b>". $row['address'];
				$userinfo['email']= "<b>Email: " ."&nbsp;&nbsp;&nbsp;</b>". $row['email'];
			}

   function display_info($userinfo=array()){
   $output = "";
   if (!empty($userinfo)){ 

     $output .=$userinfo['dbusername'] . "<br />";
	$output .=$userinfo['pin'] ."<form class=\"modify\" action=\"changepin.php\" method=\"post\" >" . "&nbsp;&nbsp;&nbsp;". "<button class=\"mod\" type=\"submit\" name=\"submit\" >Edit</button></form>". "<br />";
     $output .=$userinfo['phone'] ."<form class=\"modify\" action=\"changephone.php\" method=\"post\" >" . "&nbsp;&nbsp;&nbsp;". "<button class=\"mod\" type=\"submit\" name=\"submit\" >Edit</button></form>". "<br />";
     $output .=$userinfo['addr'] ."<form class=\"modify\" action=\"changeaddr.php\" method=\"post\" >" . "&nbsp;&nbsp;&nbsp;". "<button class=\"mod\" type=\"submit\" name=\"submit\" >Edit</button></form>". "<br />";
     $output .=$userinfo['email'] ."<form class=\"modify\" action=\"changeemail.php\" method=\"post\" >" . "&nbsp;&nbsp;&nbsp;". "<button class=\"mod\" type=\"submit\" name=\"submit\" >Edit</button></form>". "<br /></div>";

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
							<form action="myprofile.php" method="post">
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
		<div id="profile-info">
			<div id="display-profile">
				<div class="reg">
					 <h3>Your current profile: </h3><br /><br />
							<?php echo display_info($userinfo); ?>
						 		
						 <script type="text/javascript">
							function validate(){
							   var result=confirm("Are you sure? Upon clicking yes, your profile information will be removed permenantly from our database.");
							   if (!result){
							   	  return false;
							   }
							   else {
							   	window.location = "delete_account.php";
							   	return true;
							   }
							   	  
							}
						</script>					
					    <form onsubmit="event.preventDefault(); validate();">
					 	<input id="delete-button" type="submit" name="submit" value="DELETE ACCOUNT">
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