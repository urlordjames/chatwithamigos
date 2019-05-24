<?php
	require_once("../protect.php");
	$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 ',.?";
	$message = "";
	#TODO: allow admins to bypass sanitization
	foreach (str_split($_POST["message"]) as $char) {
		$valid = false;
		foreach(str_split($alphabet) as $letter) {
			if ($char == $letter) {
				$valid = true;
			}
		}
		if ($valid) {
			$message .= $char;
		}
		else {
			header("Location: /chat/message");
			exit();
		}
	}
	if (strlen($message) > 100) {
		header("Location: /chat/message");
		exit();
	}
	$conn = mysqli_connect("localhost", "id9048083_messagesuser", "despacito", "id9048083_messages");
	if ($conn->connect_error) {
		die("unable to secure channel: " . $conn->connect_error);
	}
	$query = "INSERT INTO channel1 (username, message, timestamp) VALUES (?, ?, ?)";
	$stmt = mysqli_prepare($conn, $query);
	if (!$stmt) {
		die('mysqli error: '.mysqli_error($conn));
	}
	$date = (string)date_timestamp_get(date_create());
	mysqli_stmt_bind_param($stmt, "ssi", $username, $message, $date);
	if (!mysqli_execute($stmt)) {
		die('stmt error: '.mysqli_stmt_error($stmt));
	}
	header("Location: /chat/message");
	exit();
?>
