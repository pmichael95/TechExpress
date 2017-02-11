<?php 
  session_start();
  //Check to see if the login was successful and the session variable exists.
  if(!isset($_SESSION['name'])){
    header("Location: ../login.php");
  }
?>