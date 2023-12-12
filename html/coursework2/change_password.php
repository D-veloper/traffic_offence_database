<?php
session_start(); // start the session to access session variable

if (!isset($_SESSION['username'])) { // check if the user is not logged in. If true...
    header("Location: login.php"); // redirect the user to the login page
    exit(); // terminate this script
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { /** If the user has pressed login (submitted the form) */
    // assign the user's input into the following variables
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

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

    $sql = "SELECT Password FROM Login_Credentials WHERE Username = '{$_SESSION['username']}'";
	$result = mysqli_query($conn, $sql);
    $old_password = mysqli_fetch_assoc($result)['Password'];

    if($new_password == $old_password)
    {
        $error_message = "Please insert a different password than your current one.";
    }
    elseif ($new_password == $confirm_password) {
        $sql = "UPDATE Login_Credentials SET Password = '$new_password' WHERE Username = '{$_SESSION['username']}'";
        mysqli_query($conn, $sql);
        header("Location: main_page.php"); // redirect to main page
        exit();
    }
    else{
        $error_message = "Passwords do not match. Please ensure both entries are the same.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<html>
    <head>
        <title>Traffic Incident System: Login</title>
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
                <label for="new_password">New Password:</label>
                <input type="text" name="new_password" required><br>
                <label for="confirm_password">Confirm Password:</label>
                <input type="confirm_password" name="confirm_password" required><br>
                <input type="submit" value="Set Password" class="login-button" style = "font-size: 0.5em; bottom: 70px; left: 42.5%; position: fixed;">
            </form>
        </div>
    </body>
</html>
