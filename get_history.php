<?php
	include('connection.php');
	$q = $_REQUEST['q'];
	//$q = 'abcd';

	$query = "SELECT DISTINCT search_name, search_time FROM products WHERE username = '$q' ORDER BY search_time DESC";
	$result = mysqli_query($conn, $query);
	$text = "<table><tr><th>Name</th><th>Time</th></tr>";

	while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
		$text .= "<tr>";
		$text .= "<td>";
		$text .= (string)$row[0];
		$text .= "</td>";
		$text .= "<td>";
		$text .= (string)$row[1];
		$text .= "</td>";
		$text .= "</tr>";
	}

	$text .= "</table>";
	echo $text;
	mysqli_close($conn);

?>