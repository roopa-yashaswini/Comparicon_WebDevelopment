<?php
	include('connection.php');
	session_start();
	if(!isset($_SESSION['username'])){
		header('location: login.php');
		die();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Issues</title>
	
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

	<link rel="stylesheet" type="text/css" href="stylesheets/admin_issues_style.css?v=2" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="javascript/functions.js"></script>
</head>

<body onload="show_issues()">
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
		<a href="add_user.php">Add Users</a>
		<a href="remove_user.php">Remove Users</a>
		<a href="admin_chat.php">Chat</a>
		<a href="#">Issues</a>
	</div>

	<!--Main content of the page (issues reported)-->
	<div id="main_content">
		<div id="issues">
		
		</div>
	</div>
	
</body>
</html>

