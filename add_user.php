<?php
	//checking session
	session_start();
	if(!isset($_SESSION['username'])){
		header('location: login.php');
		die();
	}

	include('connection.php');

	//adding a new user to database
	if(isset($_POST['add'])){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$password = $_POST['pwd'];
		$type = $_POST['type'];

		$hashed = md5($password);

		$check = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
		$check_res = mysqli_query($conn, $check);
		$count = mysqli_num_rows($check_res);

		if($count == 0){
			$insert = "INSERT INTO users(username, email, phone, password, type) VALUES('$username', '$email', '$phone', '$hashed', '$type')";
			if($conn->query($insert)){
				echo "<script>alert('User Added');</script>";
				echo "<script>location.replace('add_user.php');</script>";
			}
		}else{
			echo "<script>alert('Username or Email already exists.');</script>";
		}
	}
	mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add User</title>

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
	
	<link rel="stylesheet" type="text/css" href="stylesheets/add_user_style.css?v=2" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="javascript/functions.js?v=2"></script>
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
			<!--<img src="login_avatar1.png" id="avatar"  alt="Login Image" onmouseover ="display_options(1)" onmouseout="display_options(0)">-->
			<div id="login_dropdown">
				<a href="upload_image.php">Change Avatar</a>
				<a href="update_password.html">Update Password</a>
				<a href="logout.php">Logout</a>
			</div>		
		</div>
	</div>

	<!--Side Navigation-->
	<div id="sidenav">
		<a href="#">Add Users</a>
		<a href="remove_user.php">Remove Users</a>
		<a href="admin_chat.php">Chat</a>
		<a href="admin_issues.php">Issues</a>
	</div>

	<!--Main content of the page (adding user form)-->
	<div id="main_content">
		<h2>Add User</h2>
		<form name="add_user" onsubmit="return add_user_validation()" action="#" method="POST">
			<input type="text" name="username" id="username" placeholder="Username" required />
			<input type="text" name="email" id="email" placeholder="Email" required />
			<select name="type" id="type">
				<option value="user">User</option>
				<option value="admin">Admin</option>
			</select>
			<input type="text" name="phone" id="phone" placeholder="Contact number" required />
			<input type="password" name="pwd" id="pwd" placeholder="Pasword" required />
			<input type="submit" name="add" id="add" value="Add User" />
		</form>
	</div>
</body>
</html>