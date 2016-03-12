<?php 
   session_start();
   if (!$_SESSION['name'])
   		header('Location: index.php');
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
     		<a class="hvr-shutter-in-horizontal button" style="margin-left:1%">DISPLAY MY ITEMS</a>
  		</div>
		
		<div id="item-form">
			<div class="reg-form">
				<div class="reg">
					 <p>Please enter the following information for the new item you plan to sell.</p>
					 <form action="register.php" method="post">
						 <ul>
							 <li class="text-info">Name: </li>
							 <li><input type="text" id="username "name="username" placeholder="name of the item"></li>
						 </ul>
						<ul>
							 <li class="text-info">Type: </li>
							 <li><input type="text" id="email "name="email" placeholder="type of the item (e.g. food, drink, etc.)"></li>
						</ul>
						<ul>
							 <li class="text-info">Preparation Time: </li>
							 <li><input type="text" id="email "name="email" placeholder="can be made in _____ minutes?"></li>
						 </ul>
						 <ul>
							 <li class="text-info">Nutrition info: </li>
							 <li><input type="text" id="email "name="email" placeholder="notes on nutrition, allergens, etc."></li>
						 </ul>
						  <ul>
							 <li class="text-info">Price: </li>
							 <li><input type="text" id="email "name="email" placeholder="without the dollar sign"></li>
						 </ul>
								
						 <p id="signup_error">
						 	
						 </p>
						 <div align="center">
						 <input id="regbutton"type="submit" name="submit" value="CREATE">
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