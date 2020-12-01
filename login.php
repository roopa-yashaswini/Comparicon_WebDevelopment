<?php
	session_start();
	include('connection.php');

	//if cookie exists, directed to home/admin page
	if(isset($_COOKIE['username'])){
		$name = $_COOKIE['username'];
		$query = "SELECT type FROM users WHERE username = '$name'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($row[0] == 'user'){
			header("location: home.php");
		}else{
			header("location: admin.php");
		}		
	}

	//if not logout, directed to home/admin page
	if(isset($_SESSION['username'])){
		$name = $_SESSION['username'];
		$query = "SELECT type FROM users WHERE username = '$name'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($row[0] == 'user'){
			header("location: home.php");
		}else{
			header("location: admin.php");
		}		
	}

	//if username and password are valid directed to home page or admin page according to the type
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['pwd'];
		$hashed = md5($password);

		$query = "SELECT type FROM users WHERE username = '$username' AND password = '$hashed'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		$count = mysqli_num_rows($result);

		if($count == 1){
			$_SESSION['username'] = $username;
			if(!empty($_POST['remember'])){
				setcookie("username", $username, time()+(10*24*60*60));
				setcookie("pwd", $password, time()+(10*24*60*60));
			}
			if($row[0] == 'user'){
				header('location: home.php');
			}else{
				header('location: admin.php');
			}
			
		}else{
			echo "<script>window.alert('Invalid Login');</script>";
			echo "<script>location.replace('login.php');</script>";
		}
	}
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
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
	<link rel="stylesheet" type="text/css" href="stylesheets/login_style.css?v=1" />
</head>
<body>
	<!--header of the page-->
	<div id="header">
		<div id="logo_place">
			<img src="compare_logo.jpg" id="logo" alt="Website Logo">
		</div>
		<h1>Comparicon</h1>
	</div>

	<!--Main content of the page (login form)-->
	<div id="container">
		<h2>Login</h2>
	<div id="credentials">
		
		<form action="login.php" method="POST">
			<div class="row">
				<input type="text" name="username" id="username" placeholder="Username" required>
			</div>
			<div class="row">
				<input type="password" name="pwd" id="pwd" placeholder="Password" required>
			</div>
			<div id="rem_div">
				<input type="checkbox" name="remember" id="remember">
				<label for="remember">Remember me</label>
			</div>
			<input type="submit" name="login" id="login" value="Login">
			<div class="link"><a href="forgot_password.html">Forgot Password?</a></div>
			<div class="link"><a href="register_page.html">Not a User?</a></div>
		</form>
	</div>
</div>
</body>
</html>


