<?php
	include('connection.php');
	if(isset($_POST['change'])){
		$email = $_POST['email'];
		$current = $_POST['current'];
		$new = $_POST['new_pwd'];
		$hashed_current = md5($current);

		$search_query = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_current'";
		$result = mysqli_query($conn, $search_query);
		$count = mysqli_num_rows($result);

		//updating the password if the current password and username match
		if($count == 1){
			$hashed = md5($new);
			$update = "UPDATE users SET password = '$hashed' WHERE email = '$email'";
			if(mysqli_query($conn, $update)){
				echo "<script>window.alert('Password Updated');</script>";
				echo "<script>location.replace('login.php');</script>";
			}	
		}else{
			echo "<script>window.alert('Invalid Credentials');</script>";
			echo "<script>location.replace('update_password.html');</script>";
		}
	}
	mysqli_close($conn);
?>