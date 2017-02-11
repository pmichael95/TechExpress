<?php
  include './components/login-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get order ID from the header
    $id = $_GET["id"];
    
    //Setup the query to delete the order item $id
    $deleteOrderItem = "DELETE FROM `order_item` WHERE `orderID` = $id";
    //Setup the query to delete the order of that $id
    $deleteOrder     = "DELETE FROM `order` WHERE `orderID` =$id";
    //Run the queries
    $myDB->modify($deleteOrderItem);
    $myDB->modify($deleteOrder);   

    header("Location: orders.php?deleted=$id");
  }
?>