<html>
	<head>
		<title>login</title>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>
	<body>
		<form action="login.php" method="post">
			<input type="text" name="username">
			<input type="password" name="password">
			<div class="g-recaptcha" data-sitekey="6LdET6IUAAAAAL4ZSxxa1AGh7LKyp9x1kUvMpqaH"></div>
			<input type="submit" value="Submit">
		</form><br>
		currently registered users:<br>
		<?php
			$conn = new mysqli("localhost", "id9048083_bruhman", "despacito", "id9048083_users");
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$result = $conn->query("SELECT * FROM users");
			while ($row = $result->fetch_assoc()) {
				echo $row["username"]."<br>";
			}
		?>
	</body>
</html>
