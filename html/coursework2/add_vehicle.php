<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $licence_number = $_POST["licence_number"];
    $vehicle_type = $_POST["vehicle_type"];
    $people_ID = $_POST["people_ID"];
    $vehicle_colour = $_POST["vehicle_colour"];

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

    $sql = "SELECT MAX(Vehicle_ID) FROM Vehicle;"; // get the highest vehicle id to increment it for our new id
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $new_ID = $row["MAX(Vehicle_ID)"];
    $new_ID = $new_ID + 1;

    $sql = "SELECT People_ID FROM People WHERE People_ID = '$people_ID';";
    $result = mysqli_query($conn, $sql);

    
	if(mysqli_num_rows($result) == 0) //if the person is not in our system, we need to add them too. Handled in another page 
	{
		$_SESSION['licence_number'] = $licence_number;
        $_SESSION['vehicle_type'] = $vehicle_type ;
        $_SESSION['people_ID'] = $people_ID;
        $_SESSION['vehicle_colour'] = $vehicle_colour;
        $_SESSION['vehicle_ID'] = $new_ID;

        header("Location: add_vehicle_people.php"); // redirect
    	exit();
    }
    else
    {
        if($vehicle_type != "")
        {
            $sql = "INSERT INTO Vehicle VALUES ($new_ID, '$vehicle_type','$vehicle_colour','$licence_number');"; // add the new vehicle to our database
            mysqli_query($conn, $sql);
    
            $sql = "INSERT INTO Ownership VALUES ($people_ID, $new_ID);"; //update the ownership relationship
            mysqli_query($conn, $sql);
        }

        $vehicle_type = "";
        $vehicle_colour = "";
    }

    // Close the database connection
    mysqli_close($conn);

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

            <h2 style="color: white; z-index: 1; position: fixed; left: 480; top: 150">Please enter the details of the vehicle you wish to add.</h2>

            <form method="POST" class="login-form">
				<label for="licence_number">Plate Number:</label>
				<input type="text" name="licence_number" maxlength="7"><br>

                <label for="vehicle_type">Vehicle Type:</label>
				<input type="text" name="vehicle_type" maxlength="20" required><br>

				<label for="vehicle_colour">Vehicle Colour:</label>
				<input type="text" name="vehicle_colour" maxlength="20" required><br>

                <label for="people_ID">People ID:</label>
				<input type="text" name="people_ID" maxlength="11" required><br>

				<input type="submit" value="Add" class="login-button" style = "font-size: 0.8em; bottom: 10px; left: 42.5%; position: fixed;">
			</form>

			<a href="main_page.php" class="back-arrow">
            	<img src="images/back_arrow.png" alt="Back Arrow">
        	</a>
		</div>
	</body>
</html>