<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}
?>

<html>
	<head>
		<title>Traffic Incident System: Main Page</title>
		<link rel="stylesheet" href="css/format.css">
	</head>

	<body>
		<div class="background-image-2"></div>

		<div class="content">
			<img src="images/traffic_light.png" alt="Traffic Light" class="traffic-light">
			<img src="images/uon.png" alt="University of Nottingham Logo" class="uon-logo">

			<div class="dropdown"> <!-- class to style our drop down menu -->
				<img src="images/person.png" alt="Person Icon" class="person-icon"> <?php echo '<span style="color: white; position: fixed; line-height: 60px;">' . $_SESSION['username'] . '</span>'; ?> <img src="images/drop_arrow.png" alt="Drop down arrow" class="drop-arrow"> <!-- on a single line, display a person icon, the username and a dropdown arrow for the menu -->
				<div class="dropdown-content"> <!-- class to style the drop down content-->
					<!-- link each option to our desired php page -->
					<a href="change_password.php">Change Password</a> 
					<a href="logout.php">Logout</a>
				</div>
			</div>

			<div class="search-person">
			</div>

			<div class="search-vehicle">
			</div>

			<div class="add-vehicle">
			</div>
		</div>
	</body>
</html>

