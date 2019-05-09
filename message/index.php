<?php
	require_once("../protect.php");
?>
<html>
	<head>
		<title>stuffs</title>
	</head>
	<body>
		<?php
			$f = fopen("1.channel", "r") or die("unable to secure channel");
			echo(fread($f, filesize("1.channel")));
			echo("<br>" . $username . "<br>");
		?>
		<form action="message.php" method="post">
			<input type="text" name="message">
			<input type="submit" value="Submit">
		</form><br>
	</body>
</html>
