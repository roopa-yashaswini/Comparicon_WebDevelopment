<?php
	//destroying the session and cookie on logout
	session_start();
	if(isset($_COOKIE['username'])){
		setcookie("username", "", time()-1);
		setcookie("pwd", "", time()-1);
	}
	session_destroy();
	header('location: index.html');
?>