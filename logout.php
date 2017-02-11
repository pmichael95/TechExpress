<?php
//End the session and log the user out.
	session_start();
	session_unset();
	session_destroy();
	header('Location: index.php');
?>