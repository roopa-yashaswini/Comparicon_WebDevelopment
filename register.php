<?php
	include('connection1.php');
	if(isset($_POST['register'])){
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
				echo "<script>alert('Registration Successful.');</script>";
				echo "<script>location.replace('login.php');</script>";
			}
		}else{
			echo "<script>alert('Username or Email already exists.');</script>";
			echo "<script>location.replace('register_page.html');</script>";
		}
	}
	mysqli_close($conn);
	
?>


