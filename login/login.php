<?php

	session_start();

	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}

	if (isset($_POST["g-recaptcha-response"]) && isset($_POST["username"]) && isset($_POST["password"])) {
		$alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		$lename = "";
		foreach (str_split($_POST["username"]) as $char) {
			$valid = false;
			foreach (str_split($alphabet) as $letter) {
				if ($char == $letter) {
					$valid = true;
				}
			}
			if ($valid) {
				$lename .= $char;
			}
			else {
				echo("username not valid<br>");
				exit();
			}
		}
		$response = $_POST["g-recaptcha-response"];
		$username = $lename;
		$password = hash("sha512", $_POST["password"]);
	}
	else {
		exit();
	}
	
	function verify($capdata)
	{
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array
		(
			'secret' => "6LdET6IUAAAAADwBOi2PEAz4CXz25XbFY9pHGW5y",
			'response' => $capdata,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		);
		$options = array
		(
			'http' => array (
				'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context = stream_context_create($options);
		$verify = file_get_contents($url, false, $context);
		$captcha_success=json_decode($verify);
		if ($captcha_success->success==false)
		{
			return false;
		} else if ($captcha_success->success==true)
		{
			return true;
		}
		else
		{
			return false;
			echo("wtf did you do?");
			exit();
		}
	}
	
	if (verify($response) == true) {
		echo("did a thing maybe?<br>");
		$conn = mysqli_connect("localhost", "id9048083_bruhman", "despacito", "id9048083_users");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$query = "SELECT * FROM users WHERE username=\"" . $username . "\"";
		$result = $conn->query($query);
		$dbpasswd = $result->fetch_assoc()["password"];
		$dbname = $result->fetch_assoc()["username"];
		if ($password == $dbpasswd){
			echo("yes");
			$_SESSION["username"] = $dbname;
		}
		else {
			echo("no");
			exit();
		}
	}
	else {
		echo("false");
		exit();
	}
?>
