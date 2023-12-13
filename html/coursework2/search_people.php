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

$name_search = isset($_POST['name_search']) ? $_POST['name_search'] : ""; //if name_search is nothing, set it to be empty else it is what user entered
$license_search = isset($_POST['license_search']) ? $_POST['license_search'] : "";

function searchByName($conn, $name_search) //function to search our database
{
	if($name_search != "") // if they did not enter anything and hit search, prompt them to enter a valid name
	{
		$sql = "SELECT * FROM People WHERE LOWER(People_name) LIKE LOWER('%$name_search') OR LOWER(People_name) LIKE LOWER('$name_search%')"; //convert user input and database value into common form (upper case) so caps do not matter. Select the entire rows in the people class where the name is like the user input but what the user inputs might appear anywhere in People_name.
		$result = mysqli_query($conn, $sql); // storx the result of our query
		$spacing = 215; // variable to space out out answers. <br> break is breaking my poor ui lol

		if(mysqli_num_rows($result) == 0) //if there are no rows then the name is not in our system
		{
			echo '<span style="color: red; position: fixed; line-height: 215px; left: 360; z-index: 1;">'."No results found for '$name_search'". '</span>';
		}
	
		else{
			// loop through each row and output the data. customize style because background is black it won't show on default. Also position it where we want.
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<span style="color: white; position: fixed; line-height: ' . $spacing . 'px; left: 500; z-index: 1;">'.$row["People_ID"]." ".$row["People_name"]." ".$row["People_address"]." ".$row["People_licence"].'</span>';
				$spacing = $spacing + 50; // Increment spacing so the next is at a lower line height.
			}
		} 
	}
	else // this is where we tell the user to enter a name if they hit search when it is empty
	{
		echo '<span style="color: red; position: fixed; line-height: 215px; left: 360; z-index: 1;">'."Please enter a name to search". '</span>';
	}

}

if (isset($_POST['submit_name_search'])) { //when submit is pressed, handle name search
    searchByName($conn, $name_search);
}

 // Close the database connection
 mysqli_close($conn);

?>

<html>
	<head>
		<title>Traffic Incident System: Search People</title>
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
				<div class="search-bar" style="left: 350">
					<button type="submit" name="submit_name_search" class="search-button">
						<img src="images/search_icon.png" alt="Search Icon" class="search-icon">
					</button>
					<input type="text" name="name_search" class="search-input" value="<?php echo $name_search; ?>" placeholder="Search Name...">
				</div>

				<div class="search-bar" style="left: 800">
					<button type="submit" name="submit_license_search" class="search-button">
						<img src="images/search_icon.png" alt="Search Icon" class="search-icon">
					</button>
					<input type="text" name="license_search" class="search-input" value="<?php echo $license_search; ?>" placeholder="Search License Number...">
				</div>
			</form>
		</div>
	</body>
</html>

