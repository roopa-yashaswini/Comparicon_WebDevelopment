<?php
	$host = 'localhost';
	$username = 'root';
	$pwd = '';
	$db = 'crawling';

	$conn = mysqli_connect($host, $username, $pwd, $db);
	if($conn->connect_error){
		die("Connection failed".$conn->error);
	}
?>