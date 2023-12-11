<!DOCTYPE html> <!-- I know it's a php file but it looked weird in my browser without saying this-->
<html> 
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- to ensure webpage adapts to the width of device screen-->
    <link rel="stylesheet" href="css/format.css"> <!-- linking my css file to format the layout of the home page-->
    <title>Traffic Incident System: Home</title> <!-- this is what will appear in the browser title bar-->
</head>
<body>
    <div class="background-image"></div> <!-- this class will style the background image in my home page -->

    <div class="content"> <!-- this class stores the main content in my home page -->
		<!-- my homepage mainly consists of some texts, icons and a login button -->
        <h1 class="centre-heading">Traffic Incident System</h1> <!-- heading 1. The main heading on our home page styled to be centred using a class "center-text" -->
		<p1 class="centre-paragraph">Report on the go! Incident management made easy.</p1> <!-- the only other text on my homepage. a centred paragraph -->
        <img src="images/traffic_light.png" alt="Traffic Light" class="traffic-light"> <!-- traffic light image. specified the source and an alternative text. I learnt that this is good practice for accessibility reasons -->
		<img src="images/uon.png" alt="Uni Logo" class="uni-logo"> <!-- university of nottingham logo. For this image anx the one above, their respective classes are used for styling-->
        
        <div class="button-position"> <!-- a separate division for the login button. This class will handle the position of the login button -->
            <a href="login.php" class="login-button">Login</a> <!-- the actual login button hyperlinked (anchor) to the login page (login.php). text displays login and uses the login-button class for styling -->
        </div>
    </div>
</body>
</html>
