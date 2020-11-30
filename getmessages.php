<?php
	include('connection.php');
	$username = $_REQUEST['q'];
	$text = "";

	$query = "SELECT sender_id, message, time_sent FROM messages WHERE receiver_id = '$username' ORDER BY time_sent DESC";
	$result = mysqli_query($conn, $query);


	while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
		$text .= "<div class='single'><span class='from'>";
		$text .= (string)$row[0]."</span><span class='time'>";
		$text .= (string)$row[2]."</span><p class='text'>";
		$text .= (string)$row[1]."</p>";
		$text .= "</div>";
	}
	echo $text;
	mysqli_close($conn);
?>