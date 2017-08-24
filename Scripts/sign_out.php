<?php
	// start session
	session_start();

	if(isset($_SESSION['userId'])) {

		// remove all session variables
		session_unset(); 

		// destroy the session 
		session_destroy(); 
		
		header('Location: ../index.php');
		exit;
		
	} else {
			header('Location: ../Pages/sign_in.php');
		exit;
	}
?>