<?php
	require_once("../protect.php");
?>
<html>
	<head>
		<title>channel1</title>
	</head>
	<body>
		<?php
			$conn = mysqli_connect("localhost", "id9048083_messagesuser", "despacito", "id9048083_messages");
			if ($conn->connect_error) {
				die("unable to secure channel: " . $conn->connect_error);
			}
			$result = $conn->query("SELECT * FROM channel1");
			while ($row = $result->fetch_assoc()) {
				echo("[" . $row["username"] . "]" . " " . $row["message"] . "<br>\n");
			}
		?>
		<form action="message.php" method="post">
			<input type="text" name="message">
			<input type="submit" value="Submit">
		</form><br>
	</body>
</html>
