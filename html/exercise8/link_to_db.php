<html>
	<head>
		<title>Exercise 8: Link to DB</title>
		<link rel="stylesheet" href="css/mvp.css">
	</head>
	<body>	
		<main>
			<h1>Connecting to the Database</h1>
			<form method="POST">
				Name: <input type="text" name="name"><br/>
				Phone: <input type="text" name="phone"><br/>
				<input type="submit" value="Add Record">
			</form>
			<hr/>
			<?php
			// MySQL database information
			$servername = "mariadb";
			$username = "root";
			$password = "rootpwd";
			$dbname = "phpdemos";

			$conn = mysqli_connect($servername, $username, $password, $dbname);
			//other code here
			if(mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL:".mysql_connect_error();
				die();
			}
			else
				echo "MySQL connection OK<br/><br/>";
			// Adding new Records
			if($_POST['name']!="" && $_POST['phone']!="")
			{
				$sql = "INSERT INTO People(Name, PhoneNumber) VALUES ('".$_POST['name']."',".$_POST['phone'].");";
				$result = mysqli_query($conn, $sql);
			}
			// Deleting Existing Records
			if ($_GET['del'] != "")
			{
				$sql = "DELETE FROM PEOPLE WHERE ID=".$_GET['del'].";";
				$result = mysqli_query($conn, $sql);
			}
			// construct the SELECT query
			$sql = "SELECT * FROM People ORDER BY Name;";
			// send query to database
			$result = mysqli_query($conn, $sql);
			// return the number of rows that have been retrieved
			echo mysqli_num_rows($result)." rows<br/>";
			// extract the tuples that were returned by the query from $result
			if(mysqli_num_rows($result) == 0) //if there are no rows
			{
				echo "Database is empty<br/><br/>"; // database is mt
			}
			else
				while($row = mysqli_fetch_assoc($result))
				{
					echo "<li>".$row["Name"]." (phone: ".$row["PhoneNumber"].") ";
					$id = $row["ID"];
					//echo " ID:".$id;
					echo "<a href='?del=$id'>delete</a>";
					echo "<br/>";
				}
			//Adding new records
			mysqli_close($conn)
			?>
		</main>
	</body>
</html>