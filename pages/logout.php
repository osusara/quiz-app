<?php

	session_start();

	// Removing all the values in session
	$_SESSION = array();

	// Removing Cookies
	if(isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time()-86400, '/');
    }

    // Destroying the session
    session_destroy();

    header('Location: ../index.php?logout=true');
?>