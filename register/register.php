<?php

	if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
		$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
	}

	$response = $_POST["g-recaptcha-response"];
	
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
			echo "wtf did you do?";
		}
	}
?>