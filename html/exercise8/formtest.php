<html>
	<head>
		<title>Exercise 8</title>
		<link rel="stylesheet" href="css/mvp.css">
	</head>
	<body>	
		<main>
			<h1>Form Test</h1>
			<form method="get">
			Enter your name: <input type="text" name="yourname">
			<input type="submit" value="Say Hello">
			</form>
			<?php
			if (isset($_GET['yourname']))
				echo "Hello <strong>".$_GET['yourname']."</strong>";
			?>
		</main>
	</body>
</html>