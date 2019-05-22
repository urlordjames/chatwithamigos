<?php
	require_once("../protect.php");
	if (!isset($_GET["channel"])) {
		exit();
	}
	$nums = "1234567890";
	$channelnum = "";
	foreach (str_split($_GET["channel"]) as $char) {
		$valid = false;
		foreach(str_split($nums) as $number) {
			if ($char == $number) {
				$valid = true;
			}
		}
		if ($valid) {
			$channelnum .= $char;
		}
		else {
			exit();
		}
	}
	$conn = mysqli_connect("localhost", "id9048083_messagesuser", "despacito", "id9048083_messages");
	if ($conn->connect_error) {
		die("unable to secure channel: " . $conn->connect_error);
	}
	$result = $conn->query("SELECT * FROM channel" . $channelnum);
	while ($row = $result->fetch_assoc()) {
		echo("[" . $row["username"] . "]" . " " . $row["message"] . "<br>\n");
	}
?>