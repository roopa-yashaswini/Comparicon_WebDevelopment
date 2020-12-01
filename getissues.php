<?php
	include('connection.php');
	$text = "";

	//getting issues reported by the users
	$query = "SELECT issuer_id, issue, issue_time, to_id FROM issues ORDER BY issue_time DESC";
	$result = mysqli_query($conn, $query);


	while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
		$text .= "<div id='single'><span id='from'>From: ";
		$text .= (string)$row[0]."</span><span id='time'>";
		$text .= (string)$row[2]."</span><p id='text'>";
		$text .= (string)$row[1]."</p>";
		$text .= "<span id='complain'>Issue on:</span><span>";
		$text .= (string)$row[3]."</span>";
		$text .= "</div>";
	}
	echo $text;
	mysqli_close($conn);
?>