<?php

	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}

	$response = $_POST["g-recaptcha-response"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	if (!$response || !$username || !$password) {
		#TODO: sanitize
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
		}
	}
	
	if (verify($response) == true) {
		echo("did a thing maybe?<br>");
		$conn = new mysqli("localhost", "id9048083_bruhman", "despacito", "id9048083_users");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$query = $conn->query("INSERT INTO users (username, password, userid, admin, warnings) VALUES (?, ?, NULL, ?, ?");
		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "ssisi", $username, $password, "FALSE", 0)
		mysqli_stmt_execute($stmt)
	}
	else {
		echo("false");
	}
?>