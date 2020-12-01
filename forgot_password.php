<?php
	include('connection.php');
	
	if(isset($_POST['check'])){
		$email = $_POST['email'];
		$phone = $_POST['phone'];

		$search_query = "SELECT * FROM users WHERE email = '$email' AND phone = '$phone'";
		$result = mysqli_query($conn, $search_query);
		$count = mysqli_num_rows($result);

		//check if the credentials are corrects and give a random string as password and update in database
		if($count == 1){
				$characters = 'abcdefghijklmnopqrstuvwxyz1234567890@1#%';
				$random_pwd = substr(str_shuffle($characters), 0, 6);
				$hashed = md5($random_pwd);
				$update_pwd = "UPDATE users SET password = '$hashed' WHERE email = '$email'";
				if(mysqli_query($conn, $update_pwd)){
					echo "<script>window.alert('Password: ".$random_pwd."');</script>";
					echo "<script>location.replace('forgot_password.html');</script>";
				}
		}else{
			echo "<script>alert('Invalid credentials.');</script>";
			echo "<script>location.replace('forgot_password.html');</script>";
		}
	}
	mysqli_close($conn);

?>








