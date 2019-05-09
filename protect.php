<?php
	session_start();
	
	if (isset($_SESSION["username"])) {
		$username = $_SESSION["username"];
	}
	else {
		exit();
	}
	
	function auth($username) {
		$conn = new mysqli("localhost", "id9048083_bruhman", "despacito", "id9048083_users");
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$result = $conn->query("SELECT * FROM users");
		$valid = false;
		while ($row = $result->fetch_assoc()) {
			if ($username == $row["username"]) {
				$valid = true;
			}
		}
		if (!$valid) {
			echo($username);
			exit();
		}
	}
	
	auth($username);
	
?>
