<?php
session_start(); // get the current session
session_destroy(); // terminate it
header("Location: index.php"); // Redirect to the home page
exit();
?>