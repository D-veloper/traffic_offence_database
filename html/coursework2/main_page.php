<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}

// redirect admin users to main_page with extra functionality

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

$sql = "SELECT Admin FROM Login_Credentials WHERE Username = '" . $_SESSION['username'] . "';"; // get the admin status of current user
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$admin_status = $row["Admin"];

if ($admin_status == 1) // if admin redirect user
{
	header("Location: admin_main_page.php");
	exit();
}
?>

<html>
	<head>
		<title>TIMS: Main Page</title>
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

