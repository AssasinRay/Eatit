<?php 
   session_start();
/*
   	if (!$_SESSION['queryString'])
   		header('Location: user.php');
*/
	$server_name="engr-cpanel-mysql.engr.illinois.edu";
	$user_name="eatiteat_Ray";
	$dbpassword="l!Jkaqc2)Z%J";
	$database_name="eatiteat_User";
	$connection = mysqli_connect($server_name,$user_name, $dbpassword);
	$items = array();
	$users = array();

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
           // echo $username;

			$result = mysqli_query($connection, "SELECT * FROM Product where item_name like '%$query%' ");

			while($row = mysqli_fetch_assoc($result)){
				$newItem = array();
				$newItem['item_name'] = "<div class=\"user-info\"><b>Item: " ."&nbsp;&nbsp;&nbsp;</b>". $row['item_name'];
				$newItem['Type'] = "<b>Type: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Type'];
				$newItem['Taste'] = "<b>Taste: " ."&nbsp;&nbsp;&nbsp;</b>" . $row['Taste'];
				$newItem['Ready_time'] = "<b>Prep time: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Ready_time'];
				$newItem['Nutrition']= "<b>Nutrition Info: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Nutrition'];
			    $newItem['Price'] = "<b>Price: " ."&nbsp;&nbsp;&nbsp;</b>". "$". $row['Price'];
			    $newItem['Date'] = "<b>Date Added: " ."&nbsp;&nbsp;&nbsp;</b>". $row['Date_add'];
			    array_push($items, $newItem);
			}

             /*
			$result2 =  mysqli_query($connection, "SELECT * FROM User where Username like '%$query%' ");
			while($row = mysqli_fetch_assoc($result2)){
				$newItem = array();
				$newItem['item_name'] = "<div class=\"user-info\"><b>Item: " ."&nbsp;&nbsp;&nbsp;</b>". $row['item_name'];
				
			    array_push($items, $newItem);
			}
		    */

			if (!empty($items))
				 $_SESSION["h3"] = "We've found the following items for you: ";
			else
			 	 $_SESSION["h3"] = "Sorry, no matching results were found."; 
  	        

	function display_item($userinfo=array()){
   $output = "";
   if (!empty($userinfo)){ 
   	for ($i = 0; $i < sizeof($userinfo); $i++){
     $output .=$userinfo[$i]['item_name'] . "<br />";
	$output .=$userinfo[$i]['Type'] . "<br />" ;
     $output .=$userinfo[$i]['Taste'] . "<br />"; 
     $output .=$userinfo[$i]['Ready_time'] . "<br />";
     $output .=$userinfo[$i]['Nutrition'] . "<br />";
     $output .=$userinfo[$i]['Price'] . "<br />";
     $output .=$userinfo[$i]['Date'] . "<br />";
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
				/*
				var msg = "<?php echo $_SESSION['h3'];?>";
				if (!msg)
				   document.getElementById('message').innerHTML = "Sorry, no matching results were found.";
				else
					document.getElementById('message').innerHTML = "We've found the following items for you: ";
				*/
			});
          /*
	         window.onbeforeunload = function(){
	         	return "Refreshing the page will erase the results from your last query. Please start a new search.";
	         }
	         */
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
			<h3 id="message"><?php echo $_SESSION['h3']; ?> </h3><br />
		   <?php echo display_item($items); 
		    $_SESSION['queryString'] = "";
		    /* $_POST['search'] = "";
		     $_SESSION["h3"] = ""; */
		   ?>

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