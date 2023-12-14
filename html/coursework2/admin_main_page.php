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
			<img src="images/uon.png" alt="University of Nottingham Logo" class="uon-logo">

			<div class="dropdown"> <!-- class to style our drop down menu -->
				<img src="images/person.png" alt="Person Icon" class="person-icon"> 
				<?php echo '<span style="color: white; position: fixed; line-height: 60px;">' . $_SESSION['username'] . '</span>'; ?> 
				<img src="images/drop_arrow.png" alt="Drop down arrow" class="drop-arrow"> <!-- on a single line, display a person icon, the username and a dropdown arrow for the menu -->
				<div class="dropdown-content"> <!-- class to style the drop down content-->
					<!-- link each option to our desired php page -->
					<a href="change_password.php">Change Password</a> 
					<a href="add_new_officer.php">Add New Officer</a>
					<a href="logout.php">Logout</a>
				</div>
			</div>

			<div class="search-person">
				<img src="images/search_people.png" alt ="Search People Icon" style= "width: 300; height:300;">
				<a href="search_people.php" class="login-button" style="position: fixed; top: 500; left: 250;">Search People</a>
			</div>

			<div class="search-vehicle">
				<img src="images/search_vehicle.png" alt ="Search Vehicle Icon " style= "width: 300; height:300;">
				<a href="search_vehicle.php" class="login-button" style="position: fixed; top: 500; left: 650;">Search Vehicle</a>
			</div>

			<div class="add-vehicle">
				<img src="images/add_vehicle.png" alt ="Search People Icon" style= "width: 300; height:300;">
				<a href="add_vehicle.php" class="login-button" style="position: fixed; top: 500; left: 1080;">Add Vehicle</a>
			</div>
		</div>
	</body>
</html>

