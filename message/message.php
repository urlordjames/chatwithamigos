<?php
	require_once("../protect.php");
	$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 ";
	$message = "";
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
	$f = fopen("1.channel", "a+") or die("unable to secure channel");
	fwrite($f, "[" . $username . "] " . $message . "<br>");
	header("Location: /chat/message");
	exit();
?>