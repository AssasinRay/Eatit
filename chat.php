<?php 
   session_start();
   require_once("./settings.php");

if (isset($_POST['search'])){
     $_SESSION['queryString'] = $_POST['search'];
     //echo $_SESSION['queryString'];
     header('Location: results.php');
     exit();
}

   $buyer = $_GET['user1'];
   $seller = $_GET['user2'];
   $curUser = $_SESSION['name'];
   /*
   echo "buyer: " . $buyer;
   echo "seller: " . $seller;
   echo "User: " . $curUser;
   */
   
   if ($curUser != $buyer && $curUser != $seller){
   	  ?> 
   	     <script>history.go(-1);</script>
   	   <?php
   }

   if ($curUser == $buyer)
   	 $id = $seller;
   	else
   	 $id = $buyer;
  
?>

<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<!--fonts-->
	    <link href='https://fonts.googleapis.com/css?family=Lato:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
		
	<!--//fonts-->
			<link href="css/bootstrap.css" rel="stylesheet">
			<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
			<link href="css/chatpage.css" rel="stylesheet" type="text/css" media="all" />
<meta name="description" content="Eatit - food sharing platform for Champaign, Illinois">
	<!-- for-mobile-apps -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
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
                var User = "<?php echo $_SESSION['name']; ?>";

                var other = "<?php echo $id; ?>";
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

					$.ajaxSetup({cache: false});
					  //  var lastMsg = "";
						setInterval(function(){
							getMessages(User, other);
						}, 3000);

 	            // handle the chat
				$inputArea = $('#inputMessage');
				$displayArea = $('#display');
				$inputArea.keypress(function(key){
			         if (key.which === 13) {
			         	key.preventDefault();
			         	var msg = getMsg();
			         	if (!msg) return;
			         	clearMsg();
			 
                       // sendAJAX(User, msg);
                       /*
                        var xmlhttp = new XMLHttpRequest();
            			xmlhttp.onreadystatechange = function(){
	            		if (xmlhttp.readyState==4 && xmlhttp.status==200){
	            			alert("2");
	            			
	            		//	var newMsg = document.createTextNode(xmlhttp.responseText);
	            		//	var newP = document.createElement('p');
	            		//	newP.appendChild(newMsg);
	            			
	            			alert(xmlhttp.responseText);
	            			var content = "<p>" + xmlhttp.responseText + "</p><br />";
	            			document.getElementById('display').appendChild(content);
	            		}
	            		xmlhttp.open('GET', 'insert.php?uname='+User+'msg='+msg, true);
	            		xmlhttp.send();
				       }
						*/
						$.ajax({
							  url: "php-scripts/insert.php",
							  type: "get", 
							  data:{uname:User, receiver: other, msg: msg},
							  success: function(response) {
							    var content = "<p>" + response + "</p>";
	            				$displayArea.append(content);
							  },
							  error: function(xhr) {
							    console.log("AJAX failed");
							  }
							});

				   }
				});
						
			});

			function getMsg(){
				return document.getElementById('inputMessage').value;
			}

			function clearMsg(){
				document.getElementById('inputMessage').value = "";
			}

            function getMessages(self,other){

				$.ajax({
					  url: "php-scripts/logs.php",
					  type: "get", 
					  data:{participant1: self, participant2: other},
					  success: function(response) {
					  	//console.log("Return text:  " + response);
					    $displayArea.html(response);	 
						scrollDown();
					  },
					  error: function(xhr) {
					    console.log("something weird happened");
					  }
					});
            }

            function scrollDown() {
			    var display = document.getElementById('display');
		     	display.scrollTop = display.scrollHeight ;
            }
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
	
				</div>
				<!-- start search-->
				    <div class="search-box">
					    <div id="sb-search" class="sb-search">
							<form action="chat.php" method="post">
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

	<div id="display">

	</div>

	
	<div class="inputArea" align="center">
		<div id="heading">
		
	</div>
	<textarea id="inputMessage" placeholder="Enter your message here" maxlength="140"></textarea>
	
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
<!--<script src="js/chat.js"></script>-->
</body>
</html>