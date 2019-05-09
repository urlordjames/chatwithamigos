<?php
	require_once("../protect.php");
	$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890 ',";
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
	$f = fopen("1.channel", "a+") or die("unable to secure channel");
	if ($message == "purge") {
		ftruncate($f, 0);
		fwrite($f, "hello, welcome to chat with amigos!<br>\n");
		header("Location: /chat/message");
		exit();
	}
	fwrite($f, "[" . $username . "] " . $message . "<br>\n");
	header("Location: /chat/message");
	exit();
?>