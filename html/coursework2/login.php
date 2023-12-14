<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { /** If the user has pressed login (submitted the form) */
    // assign the user's input into the following variables
    $login_username = $_POST["username"];
    $login_password = $_POST["password"];

    // MySQL database information
	$servername = "mariadb";
	$username = "root";
	$password = "rootpwd";
	$dbname = "coursework2";

    // Create a database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check the connection
	if(mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL:".mysql_connect_error();
		die();
	}

	// Check if credentials are legitimate with query. Get the rows from login credentials table which username and password matches the user's input. 
	// If login credential exists in our database, query will return one row
	$sql = "SELECT * FROM Login_Credentials WHERE Username='$login_username' AND Password='$login_password'";
	$result = mysqli_query($conn, $sql);

	// Check if the query found the user input in our database.
	if (mysqli_num_rows($result) == 1) {
    	// If credential was found, then the login is valid so we redirect user to main_page.php
		session_start();
		$_SESSION['username'] = $login_username; //session variable to store username so user cannot access other pages without having logged in successfully
		
		$_SESSION['licence_number'] = "";
        $_SESSION['vehicle_type'] = "";
        $_SESSION['people_ID'] = "";
        $_SESSION['vehicle_colour'] = "";

    	header("Location: main_page.php"); // redirect
    	exit();
	} else {
    	// Invalid login, display an error message
    	$error_message = "Username or password not recognized.";
	}
    // Close the database connection
    mysqli_close($conn);
}
?>

<html>
	<head>
		<title>TIMS: Login</title>
		<link rel="stylesheet" href="css/format.css">
	</head>
	<body>
		<div class="background-image"></div>
		<div class="content">
			<img src="images/traffic_light.png" alt="Traffic Light" class="traffic-light">
			<img src="images/uon.png" alt="University of Nottingham Logo" class="uon-logo">

			<!-- Display error message if login fails -->
			<?php if (isset($error_message)) : ?>
				<p style="color: red; font-size: 12px; bottom: 290px; position: fixed; left: 43.5%;"><?php echo $error_message; ?></p>
			<?php endif; ?>

			<!-- Login Form -->
			<form method="POST" class="login-form">
				<label for="username">Username:</label>
				<input type="text" name="username" required><br>
				<label for="password">Password:</label>
				<input type="password" name="password" required><br>
				<input type="submit" value="Login" class="login-button" style = "font-size: 0.5em; bottom: 70px; left: 42.5%; position: fixed;">
			</form>
		</div>
	</body>
</html>
