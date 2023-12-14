<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { /** If the user has pressed login (submitted the form) */
    // assign the user's input into the following variables
    $officer_name = $_POST["new_officer"];
    $officer_password = $_POST["officer_password"];
    $officer_status = 0;

    if (isset($_POST['add_as_admin'])) { // If the add as admin checkbox was ticked
        $officer_status = 1;
    }

    // MySQL database information
	$servername = "mariadb";
	$username = "root";
	$password = "rootpwd";
	$dbname = "coursework2";

    // Create a database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check the connection
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $sql = "SELECT Username FROM Login_Credentials WHERE Username = '$officer_name';";
	$result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) //if the username is not taken
    {
        $sql = "INSERT INTO Login_Credentials VALUES ('$officer_name', '$officer_password', $officer_status);";
        mysqli_query($conn, $sql);
        header("Location: admin_main_page.php"); // redirect to main page
        exit();

    }
    else
    {
        echo '<span style="color: red; position: fixed; line-height: 395px; left: 670; z-index: 1;">'."Officer name is already taken". '</span>';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<html>
    <head>
        <title>Traffic Incident System: Change Password</title>
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
                <label for="new_officer">Officer Name:</label>
                <input type="text" name="new_officer" required><br>
                <label for="officer_password">Officer Password:</label>
                <input type="officer_password" name="officer_password" required><br>
                <labe for="add_as_admin">Add as admin</label>
                <input type="checkbox" name="add_as_admin"><br>
                <input type="submit" value="Add New Officer" class="login-button" style = "font-size: 0.7em; bottom: 25px; left: 42.5%; position: fixed;">
            </form>
        </div>
    </body>
</html>
