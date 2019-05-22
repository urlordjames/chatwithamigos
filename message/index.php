<html>
	<head>
		<title>channel1</title>
	</head>
	<body>
		<script>
			function getmessages(channel) {
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("messages").innerHTML = this.responseText;
					}
				};
				xhttp.open("GET", "/chat/message/getmessages.php?channel=" + channel, true);
				xhttp.send();
			}
			var chan = "1";
			getmessages(chan);
			window.setInterval(function(chan) {getmessages(chan);}, 5000, chan);
		</script>
		<div id="messages"></div>
		<form action="message.php" method="post">
			<input type="text" name="message">
			<input type="submit" value="Submit">
		</form><br>
	</body>
</html>
