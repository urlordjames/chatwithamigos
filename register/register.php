<?php

	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}


	if ($_POST["g-recaptcha-response"] && $_POST["username"] && $_POST["password"]) {
		#TODO: sanitize username
		$response = $_POST["g-recaptcha-response"];
		$username = $_POST["username"];
		$password = hash("sha512", $_POST["password"]);
	}
	else {
		exit()
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
		$zero = 0;
		$date = (string)date_timestamp_get(date_create());
		echo("did a thing maybe?<br>");
		$conn = mysqli_connect("localhost", "id9048083_bruhman", "despacito", "id9048083_users");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$query = "INSERT INTO users (username, password, userid, admin, warnings) VALUES (?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $query);
		if (!$stmt) {
			die('mysqli error: '.mysqli_error($conn));
		}
		mysqli_stmt_bind_param($stmt, "ssssi", $username, $password, $date, $zero, $zero);
		if (!mysqli_execute($stmt)) {
			die('stmt error: '.mysqli_stmt_error($stmt));
		}
	}
	else {
		echo("false");
	}
?>