<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}

if ($_SESSION['vehicle_type'] == "" || !isset($_SESSION['vehicle_type'])) { // check if there is no vehicle info to post
    header("Location: add_vehicle.php"); // redirect the user to the login page
    exit(); // terminate this script
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $licence_number = $_SESSION['licence_number'];
    $vehicle_type = $_SESSION['vehicle_type'];
    $people_ID = $_SESSION['people_ID'];
    $vehicle_colour = $_SESSION['vehicle_colour'];
	$vehicle_ID = $_SESSION['vehicle_ID'];

	$people_name = $_POST["people_name"];
    $people_address = $_POST["people_address"];
    $people_licence = $_POST["people_licence"];

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

    $sql = "INSERT INTO Vehicle VALUES ($vehicle_ID, '$vehicle_type','$vehicle_colour','$licence_number');"; // add the new vehicle to our database
    mysqli_query($conn, $sql);

	$sql = "INSERT INTO People VALUES ($people_ID, '$people_name','$people_address','$people_licence');";
	mysqli_query($conn, $sql);

    $sql = "INSERT INTO Ownership VALUES ($people_ID, $vehicle_ID);"; //update the ownership relationship
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);

	$vehicle_type = ""; // so this page cannot be accessed again until there is a new vehicle to add and the owner is not known
	$vehicle_colour = "";

	header("Location: add_vehicle.php"); // redirect
	exit();

}

?>

<html>
	<head>
		<title>TIMS: Add Vehicle</title>
		<link rel="stylesheet" href="css/format.css">
	</head>

	<body>
		<div class="background-image-2"></div>

		<div class="content">
			<img src="images/uon.png" alt="University of Nottingham Logo" class="uon-logo">

			<div class="dropdown">
				<img src="images/person.png" alt="Person Icon" class="person-icon">
				<?php echo '<span style="color: white; position: fixed; line-height: 60px;">' . $_SESSION['username'] . '</span>'; ?>
				<img src="images/drop_arrow.png" alt="Drop down arrow" class="drop-arrow">
				<div class="dropdown-content">
					<a href="change_password.php">Change Password</a>
					<a href="logout.php">Logout</a>
				</div>
			</div>

            <h2 style="color: white; z-index: 1; position: fixed; left: 380; top: 150">The owner of this vehicle is not in the database. Please add their details.</h2>

            <form method="POST" class="login-form">
                <label for="people_name">People Name:</label>
				<input type="text" name="people_name" maxlength="50" required><br>

				<label for="people_address">People Address:</label>
				<input type="text" name="people_address" maxlength="50" required><br>

                <label for="people_licence">People Licence:</label>
				<input type="text" name="people_licence" maxlength="16" required><br>

				<input type="submit" value="Add" class="login-button" style = "font-size: 0.8em; bottom: 10px; left: 42.5%; position: fixed;">
			</form>

			<a href="main_page.php" class="back-arrow">
            	<img src="images/back_arrow.png" alt="Back Arrow">
        	</a>
		</div>
	</body>
</html>