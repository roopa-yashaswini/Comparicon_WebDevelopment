<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header('location: login.php');
		die();
	}
	include('connection.php');
	if(isset($_POST['remove'])){
		$username = $_POST['username'];
		$email = $_POST['email'];

		$query = "SELECT * FROM users WHERE username = '$username' AND email = '$email'";
		$result = mysqli_query($conn, $query);
		$count = mysqli_num_rows($result);

		if($count == 1){
			$remove_user = "DELETE FROM users WHERE username = '$username' AND email = '$email'";
			$result = mysqli_query($conn, $remove_user);
			if($result){
				echo "<script>alert('User Removed!');</script>";
				echo "<script>location.replace('remove_user.php');</script>";
			}else{
				echo "<script>alert('Error in removing the user.');</script>";
			}

		}else{
			echo "<script>alert('User not Found!');</script>";
		}
	}

	mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Remove User</title>
	
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

	<link rel="stylesheet" type="text/css" href="stylesheets/remove_user_style.css?v=0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="javascript/functions.js"></script>
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
		<a href="add_user.php">Add Users</a>
		<a href="#">Remove Users</a>
		<a href="admin_chat.php">Chat</a>
		<a href="admin_issues.php">Issues</a>
	</div>

	<!--Main content of the page (remove user form)-->
	<div id="main_content">
		<h2>Remove User</h2>
		<form name="remove_user" onsubmit="return remove_user_validation()" action="#" method="POST">
			<input type="text" name="username" id="username" placeholder="Username" required>
			<input type="text" name="email" id="email" placeholder="Email" required>	
			<input type="submit" name="remove" id="remove" value="Remove">
			
		</form>
	</div>
</body>
</html>