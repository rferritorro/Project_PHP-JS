<!DOCTYPE html>
<?php
if (empty($_GET['module'])) {
	$_GET['module'] = "home";
	
}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Auto Sell</title>
		<!--BEGIN OF TERMS OF USE. DO NOT EDIT OR DELETE THESE LINES. IF YOU EDIT OR DELETE THESE LINES AN ALERT MESSAGE MAY APPEAR WHEN TEMPLATE WILL BE ONLINE-->
<style>#free-flash-header a,#free-flash-header a:hover {color:#363636;}#free-flash-header a:hover {text-decoration:none}</style>
<!--END OF TERMS OF USE-->

<?php
if ($_GET["module"] == "home") {

	include("view/pages/top_page_home.php");
} else if ($_GET["module"] == "shop") {
	include("view/pages/top_page_shop.php");

}
?>
</head>
	
	<body>
	<div class="layer_user" style="position:fixed;width:100%;height:100%;background-color:black;opacity:0.5;z-index:149" hidden></div>
	<div class="page-container">
  	<!--BEGIN OF TERMS OF USE. DO NOT EDIT OR DELETE THESE LINES. IF YOU EDIT OR DELETE THESE LINES AN ALERT MESSAGE MAY APPEAR WHEN TEMPLATE WILL BE ONLINE-->

	<!--END OF TERMS OF USE-->	
	<div class="spinner-border text-light" id="imgSpinner1" role="status" style="position:fixed;top:45%;right:55%">
  		<span class="sr-only">Loading...</span>
	</div>
		<div class="dark-bg">
			<header>
			<div id="header_options">
				<select id="language" is="ms-dropdown">
						<option id="es" data-tr="Español" data-image="view/img/language_logo/spain-logo.png">Español</option>
						<option id="ca" data-tr="Catalán" data-image="view/img/language_logo/catalán-logo.png">Catalán</option>
						<option id="en" data-tr="Inglés" data-image="view/img/language_logo/Britanica-logo.jpg">Inglés</option>            
				</select>
				<div id="space_logger">
				</div>
    		</div>
			
			<!-- menu desplegable bootstrap -->
			<img style="position:absolute;top:-20%;left:-5%" src="./view/img/Logotipo500x500px.png"></img>
				<div class="container">

					<!-- logo -->
					<div class="col-md-4 col-xs-12 logo">
						<!-- <a href="index.php">
							<img src="images/logo.jpg" alt="logo">
						</a> -->
					</div>
					<!-- logo -->

					<div class="col-md-8 col-xs-12">
						<!-- <a class="green-btn" href="index.php">Lorem ipsum</a> -->
					</div>
					

					<!-- menu -->
					<nav class="col-md-12 col-xs-12 menu">
						<ul>
							<li class="button_menu">
								<a href="index.php?module=home&option=list">
									<span><i class="fas fa-home fa-3x"></i></span>
								</a>
							</li>
							<li class="button_menu">
								<a href="index.php?module=shop&option=list">
									<span><i class="fas fa-car fa-3x"></i></span>
								</a>
							</li>
							<li class="button_menu">
								<a href="#">
									<span><i class="fas fa-address-book fa-3x"></i></span>
								</a>
							</li>
						</ul>
							<?php
							include("search/view/search.html");
							?>
					</nav>
					<!-- menu -->
					
				</div>
			</header>
			<div id="panel_register" hidden>
				<span id="user_login_close"><i class="fas fa-window-close fa-2x"></i></span>
				<img id="img_logo" style="position:absolute;top:-27%;right:13%" src="./view/img/Logotipo500x500px.png"></img>
				<?php
					include("login/view/login.html");
					include("login/view/register.html");
				?>
			</div>
			<div class="container">
				<!-- <div class="col-md-7 col-xs-12 no_left no_right">
				

					<span><i id="button_dummies" class="fas fa-magic fa-3x"></i></span>
			
				</div> -->

				<!-- <div class="col-md-5 col-xs-12 slide no_left">
					
					<div class="col-md-12 col-xs-12 no_right slider">
						<div id="wowslider-container1">
							<div class="ws_images"><ul>
									<li><img src="view/img/img_cars/coche.png" alt="" title="Do you like this car?"  id="wows1_0"/></li>
									<li><img src="view/img/img_cars/coche2.png" alt="" title="Amazing cars" id="wows1_1"/></li>
									<li><img src="view/img/img_cars/coche3.png" alt="" title="This car is cheaper too"  id="wows1_2"/></li>
									<li><img src="view/img/img_cars/coche4.png" alt="" title="This webpage is by Rafa Ferri"  id="wows1_3"/></li>
								</ul>
							</div>

							<div class="ws_shadow"></div>
						</div>
					</div>


				</div> -->
			</div>
		</div>
	<?php
    	include("view/pages/pages.php");
    ?>
    <script type='text/javascript' src="assets/js/visuallightbox.js"></script>
    <script type='text/javascript' src="assets/js/vlbdata.js"></script>
    <!-- <script type="text/javascript" src="assets/js/wowslider.js"></script>
    <script type="text/javascript" src="assets/js/wowslider-gallery.js"></script> -->
	<script type="text/javascript" src="login/module/controller_login.js"></script>
	<script type="text/javascript" src="login/module/controller_register.js"></script>
	<script type="text/javascript" src="assets/js/main.js"></script>
	<script type="text/javascript" src="assets/js/activity.js"></script>
	<!-- <script type="text/javascript" src="assets/js/script.js"></script> -->

	<div id="dummies"></div>
  </body>
</html>