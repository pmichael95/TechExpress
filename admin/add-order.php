<?php
  include './components/login-check.php';
  include '../dbconnector.php';
  $myDB = new Database();
  //Get the employee ID from the session variable.
  $id = $_SESSION['employeeID'];
  //Add the order with that ID.
  $newOrder = "INSERT INTO `order`(`orderID`, `employeeID`, `orderDate`) 
                VALUES (NULL, $id, NOW())";
  $myDB->modify($newOrder); 
  header("Location: orders.php?added=A new order has been created.");
?>