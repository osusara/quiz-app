<?php

	$host = "localhost";
	$user = "root";
	$password = "";
	$db = "quiz-app";

	$connection = mysqli_connect($host, $user, $password, $db);

	if(mysqli_connect_errno()){
		die('Database connection error: '.mysqli_connect_error());
	}

?>