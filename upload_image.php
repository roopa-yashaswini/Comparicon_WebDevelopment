<?php
	session_start();
	if(!isset($_SESSION['username'])){
		header('location: login.html');
		die();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Upload Image</title>
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
	<script src="javascript/functions.js?v=1"></script>
	<link rel="stylesheet" type="text/css" href="stylesheets/upload_image_style.css?v=1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
	<div id="header">
		<div id="logo_place">
			<img src="compare_logo.jpg" id="logo" alt="Website Logo">
		</div>
		<h1>Comparicon</h1>
		<div class="login">
			<div id="login_dropdown" >
				<a href="upload_image.php">Change Avatar</a>
				<a href="update_password.html">Update Password</a>
				<a href="logout.php">Logout</a>
			</div>	
		</div>
	</div>
	<div id="sidenav">
		<a href="search.php">Search</a>
		<a href="website_search.php">Website</a>
		<a href="search_history.php">Search History</a>
		<a href="chat.php">Chat</a>
		<a href="issue.php">Report an Issue</a>
	</div>
	<div id="main_content">
		<h2>Upload Image</h2>
		<div id="credentials">
			<form name="image_form" action="#" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="c1"><label>Image Link</label></div>	
					<div class="c2"><input type="text" name="link" id="link" placeholder="Image link" maxlength="1000" required/></div>
				</div>
				<input type="submit" name="submit" value="Upload" id="submit" />
			</form>
		</div>
	</div>
	
</body>
</html>

<?php
	include("connection.php");

	if(isset($_POST['submit'])){
		$link = $_POST['link'];
		$username = $_SESSION['username'];

		$search = "SELECT * FROM profile_images WHERE username = '$username'";
		$result = mysqli_query($conn, $search);
		$count = mysqli_num_rows($result);

		if($count == 1){
			$update = "UPDATE profile_images SET image_link = '$link' WHERE username = '$username'";
			$result = mysqli_query($conn, $update);
			if($result){
				echo "<script>alert('Avatar Updated');</script>";
			}else{
				echo "<script>alert('Avatar Updated Failed');</script>";
			}
		}else{
			$insert = "INSERT INTO profile_images(username, image_link) VALUES ('$username', '$link')";
			$result = mysqli_query($conn, $insert);
			if($result){
				echo "<script>alert('Avatar Updated');</script>";
			}else{
				echo "<script>alert('Avatar Updated Failed');</script>";
			}
		}
	}
	mysqli_close($conn);
?>



