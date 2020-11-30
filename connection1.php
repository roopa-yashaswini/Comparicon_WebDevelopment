<?php
	$host = "localhost";
	$user = "root";
	$pwd = "";

	$conn = mysqli_connect($host, $user, $pwd);

	if($conn->connect_error){
		die("Connect failed". $conn->connect_error);
	}
	$query = "CREATE DATABASE IF NOT EXISTS crawling";
	if($conn->query($query) === TRUE){
		$query = "USE crawling";
		if($conn->query($query) === TRUE){
			$query = "CREATE TABLE users(
				username VARCHAR(50) NOT NULL PRIMARY KEY,
				email VARCHAR(50) UNIQUE NOT NULL,
				phone VARCHAR(10) NOT NULL,
				password VARCHAR(50) NOT NULL,
				type VARCHAR(10)NOT NULL
			);";
			$conn->query($query);

			$products_table = "CREATE TABLE products(
				website varchar(100) NOT NULL,
  				product_title varchar(400) NOT NULL,
  				product_link varchar(1000) NOT NULL,
  				product_price varchar(50) NOT NULL,
  				search_time datetime DEFAULT current_timestamp(),
  				username varchar(50) DEFAULT NULL,
  				search_name varchar(100) DEFAULT NULL
			);";
			$conn->query($products_table);

			$issues_table = "CREATE TABLE issues(
				issuer_id varchar(100) NOT NULL,
  				to_id varchar(100) DEFAULT NULL,
  				issue varchar(1000) NOT NULL,
  				issue_time datetime DEFAULT current_timestamp()
			);";
			$conn->query($issues_table);

			$message_table = "CREATE TABLE messages(
				sender_id varchar(100) NOT NULL,
  				receiver_id varchar(100) NOT NULL,
  				message varchar(1000) NOT NULL,
  				time_sent datetime DEFAULT current_timestamp()
			);";
			$conn->query($message_table);

			$images_table = "CREATE TABLE profile_images(
				username varchar(50) NOT NULL,
				image_link varchar(1000) NOT NULL,
				FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE
			);";
			$conn->query($images_table);

		}else{
			echo ("Not moved to crawling". $conn->error);
		}
	}else{
		echo ("Database not created". $conn->error);
	}
?>