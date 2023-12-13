<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}

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

$plate_search = isset($_POST['licence_plate_search']) ? $_POST['licence_plate_search'] : ""; //if name_search is nothing, set it to be empty else it is what user entered

function searchPlate($conn, $plate_search) //function to search our database
{
	if($plate_search != "") // if they did not enter anything and hit search, prompt them to enter a valid licende plate number
	{
		$sql = "SELECT Vehicle.Vehicle_ID, Vehicle.Vehicle_type, Vehicle.Vehicle_colour, People.People_name, People.People_licence FROM Vehicle, Ownership, People WHERE Vehicle.Vehicle_ID = Ownership.Vehicle_ID AND Ownership.People_ID = People.People_ID AND Vehicle.Vehicle_licence = '$plate_search';";
		$result = mysqli_query($conn, $sql); // storx the result of our query
		$spacing = 215; // variable to space out out answers. <br> break is breaking my poor ui lol

		if(mysqli_num_rows($result) == 0) //if there are no rows then the name is not in our system
		{
			echo '<span style="color: red; position: fixed; line-height: 215px; left: 580; z-index: 1;">'."No Vehicle found with this plate number: '$plate_search'". '</span>';
		}
	
		else{
			// loop through each row and output the data. customize style because background is black it won't show on default. Also position it where we want.
			while ($row = mysqli_fetch_assoc($result)) {
                $vehicle_type = $row["Vehicle_type"];
                $vehicle_colour = $row["Vehicle_colour"]; 
                $people_name = $row["People_name"]; 
                $people_license = $row["People_licence"];

                if(is_null($vehicle_type))
                {
                    $vehicle_type = "Unknown";
                }

                if(is_null($vehicle_colour))
                {
                    $vehicle_colour = "Unknown";
                }

                if(is_null($people_name))
                {
                    $people_name = "Unknown";
                }

                if(is_null($people_license))
                {
                    $people_license = "Unknown";
                }
				echo '<span style="color: white; position: fixed; line-height: ' . $spacing . 'px; left: 300; z-index: 1;">'."Vehicle ID: ".$row["Vehicle_ID"]."| "."Vehicle Type: ".$vehicle_type."| "."Vehicle Colour: ".$vehicle_colour."| "."Owner Name: ".$people_name."| "."Owner License: ".$people_license.'</span>';
				$spacing = $spacing + 50; // Increment spacing so the next is at a lower line height.
			}
		} 
	}
	else // this is where we tell the user to enter a name if they hit search when it is empty
	{
		echo '<span style="color: red; position: fixed; line-height: 215px; left: 620; z-index: 1;">'."Please enter a plate number to search". '</span>';
	}

}

if (isset($_POST['submit_plate_search'])) { //when submit is pressed, handle name search
    searchPlate($conn, $plate_search);
}

 // Close the database connection
 mysqli_close($conn);

?>

<html>
	<head>
		<title>Traffic Incident System: Search Vehicle</title>
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

			<form method="POST">
				<div class="search-bar" style="left: 650">
					<button type="submit" name="submit_plate_search" class="search-button">
						<img src="images/search_icon.png" alt="Search Icon" class="search-icon">
					</button>
					<input type="text" name="licence_plate_search" class="search-input" value="<?php echo $plate_search; ?>" placeholder="Enter Plate Number...">
				</div>

			</form>

			<a href="main_page.php" class="back-arrow">
            	<img src="images/back_arrow.png" alt="Back Arrow">
        	</a>
		</div>
	</body>
</html>