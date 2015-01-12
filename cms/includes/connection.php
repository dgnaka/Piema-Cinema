<?php
	require("constants.php");
	//1. Create a database connection and select db
	$connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	//mysqli
		if ($connection->connect_errno) {
			echo "Failed to connect to MySQL: (" . 
				$connection->connect_errno . ") " . 
				$connection->connect_error;
		}

	// Old mysql
	// if (!$connection) {
	// 	die("Database connection failed: " . mysql_error());
	// }
?>