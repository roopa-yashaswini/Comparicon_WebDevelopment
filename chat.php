<?php
	include('connection.php');
	//check session
	session_start();
	if(!isset($_SESSION['username'])){
		header('location: login.php');
		die();
	}

	if(isset($_POST['send'])){
		$from = $_SESSION['username'];
		$to = $_POST['receiver'];
		$message = $_POST['message'];
		$query = "SELECT username FROM users WHERE username = '$to'";
		$result = mysqli_query($conn, $query);
		$rows = mysqli_num_rows($result);

		//sending message if receiver's username exists
		if($rows == 1){
			$send = "INSERT INTO messages(sender_id, receiver_id, message) VALUES ('$from', '$to', '$message')";
			$send_status = mysqli_query($conn, $send);
			if($send_status){
				echo "<script>alert('Message Sent');</script>";
				echo "<script>location.replace('chat.php');</script>";
			}else{
				echo "<script>alert('Try again. Might be a server issue.');</script>";
				echo "<script>location.replace('chat.php');</script>";
			}
		}else{
			echo "<script>alert('Username does not exist.');</script>";
			echo "<script>location.replace('chat.php');</script>";
		}
	}
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Messages</title>

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

	<link rel="stylesheet" type="text/css" href="stylesheets/chat_style.css?v=1" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="javascript/functions.js?v=0"></script>
</head>

<body onload="show_messages('<?php echo $_SESSION['username']; ?>')">	
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
		<a href="website_search.php">Website</a>
		<a href="search_history.php">Search History</a>
		<a href="#">Chat</a>
		<a href="issue.php">Report an Issue</a>
	</div>

	<!--Main content of the page (send message and read message)-->
	<div id="main_content">
		<div id="buttons">
			<input type="button" name="new_msg" id="new_msg" value="New Message" onclick="display_message_box()" />
		</div>
		<div id="messages">
		
		</div>
	</div>
	
	<div id="popout">
		<div id="container">
			<button id="close_bt" name="close_bt" onclick="document.getElementById('popout').style.display='none'">&times;</button>
			<br><br>
			<div id="chat_content">
				<form action="#" method="POST">
					<input type="text" name="receiver" id="receiver" placeholder="Receiver Username" required />
					<textarea name="message" id="message" placeholder="Message" required></textarea>
					<input type="submit" name="send" id="send" value="Send" />
				</form>
			</div>
		</div>
	</div>
	
</body>
</html>

