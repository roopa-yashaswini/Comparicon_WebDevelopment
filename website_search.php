<?php
	//check session
	session_start();
	if(!headers_sent() && !isset($_SESSION['username'])){
		header('location: login.php');
		die();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Website Search</title>

	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="57x57" href="favicons/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="favicons/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="favicons/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="favicons/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="favicons/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="favicons/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="favicons/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="favicons/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="favicons/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="favicons/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
	<link rel="manifest" href="favicons/manifest.json">

	<link rel="stylesheet" type="text/css" href="stylesheets/website_search_style.css?v=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="javascript/functions.js?v=1"></script>
</head>
<body>
	<!--header of the page-->
	<div id="header">
		<div id="logo_place">
			<img src="compare_logo.jpg" id="logo" alt="Website Logo">
		</div>
		<h1>Comparicon</h1>
		<div class="login">
			<?php
				//retrieving the profile image of the admin if exists
				$user = $_SESSION['username'];
				include("connection.php");
				$get_image = "SELECT image_link FROM profile_images WHERE username = '$user'";
				$result = mysqli_query($conn, $get_image);
				$count = mysqli_num_rows($result);

				if($count >= 1){
					@$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					@$src_image =  file_get_contents($row['image_link']);
					@$new_info = "images/new_image.jpg";
					@$status = file_put_contents(@$new_info, @$src_image);
					if(@$status) {
    					echo '<img id="avatar" src="images/new_image.jpg" alt="Login Image">';    
    				} else{
    					echo '<img src="login_avatar1.png" id="avatar" alt="Login Image">';
    				}
				}else{
					echo '<img src="login_avatar1.png" id="avatar" alt="Login Image">';
				}
				mysqli_close($conn);
			?>
			<!--<img src="login_avatar1.png" id="avatar" alt="Login Image" onmouseover ="display_options(1)" onmouseout="display_options(0)">-->
				<div id="login_dropdown">
					<a href="upload_image.php">Change Avatar</a>
					<a href="update_password.html">Update Password</a>
					<a href="logout.php">Logout</a>
				</div>	
		</div>
	</div>

	<!--Side Navigation-->
	<div id="sidenav">
		<a href="search.php">Search</a>
		<a href="#">Website</a>
		<a href="search_history.php">Search History</a>
		<a href="chat.php">Chat</a>
		<a href="issue.php">Report an Issue</a>
	</div>
	
	<!--Main content of the page (get the product information for the selected website)-->
	<form action="#" method="GET">
		<div id="main_content">
			<select name="website" id="website">
				<option value="amazon" <?php if(isset($_GET['search'])){if($_GET['website'] == "amazon") echo "SELECTED";}?> >Amazon</option>
				<option value="flipkart" <?php if(isset($_GET['search'])){if($_GET['website'] == "flipkart") echo "SELECTED";}?> >Flipkart</option>
				<option value="snapdeal" <?php if(isset($_GET['search'])){if($_GET['website'] == "snapdeal") echo "SELECTED";}?> >Snapdeal</option>
			</select>
			<input type="text" name="search_item" id="search_item" />
			<input type="submit" name="search" id="search">
			
			<!--<button type="submit" name="search" id="search"><img src="search.png" width="2%" height="2%"></button>-->
		</div>
	</form>
	
	
</body>
</html>

<?php
	include('connection.php');
	include_once "flipkart.php";
	include_once "amazon.php";
	include_once "snapdeal.php";
	
	if(isset($_GET['search'])){
		$username = $_SESSION['username'];
		$name = $_GET['website'];
		$search_item = $_GET['search_item'];

		//getting product link, title, and price
		function get_data($website_name){
			if($website_name == 'amazon'){
				$amazon_data = Array();
				$amazon_data = amazon($_GET['search_item']);
				return $amazon_data;
			}else if($website_name == 'flipkart'){
				$flipkart_data = Array();
				$flipkart_data = flipkart($_GET['search_item']);
				return $flipkart_data;
			}else{
				$snapdeal_data = Array();
				$snapdeal_data = snapdeal($_GET['search_item']);
				return $snapdeal_data;
			}
		}

		$complete_data = Array();
		$complete_data = get_data($name);

		echo "<div class = 'products'>";
		$i = 0;

		//displaying product link, title, and price
		for($i=0; $i<10;$i++){	
				if(@$complete_data['product_name'][$i] != ""){
					$product_name = @$complete_data['product_name'][$i];
        			$link = @$complete_data['product_url'][$i];
        			$price = @$complete_data['product_price'][$i];

					echo "<div class = '".$name."'>";
        			echo "<a class='single_product_link' href = '".@$complete_data['product_url'][$i]."' target='_blank'>".@$complete_data['product_name'][$i]."</a>";
        			echo "<div class = 'single_product_price'>".@$complete_data['product_price'][$i]."</div>";
        			echo "</div>";

        			$query = "INSERT INTO products(website, product_title, product_link, product_price, username, search_name) VALUES('$name', '$product_name', '$link', '$price', '$username', '$search_item')";
        			$result = mysqli_query($conn, $query);
				}	
		}
		echo "</div>";
	}
?>

