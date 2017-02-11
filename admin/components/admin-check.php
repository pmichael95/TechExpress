<?php 
//Check to see if the current department is the admin one.
	if($_SESSION['department'] != 1){
	    header("location: /admin");
	}
?>