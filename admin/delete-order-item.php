<?php
  include './components/login-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get the IDs from the header.
    $id = $_GET['id'];
    $order = $_GET['order'];
    //Run query with the order item $id
    $deleteOrderItem = "DELETE FROM `order_item` WHERE `orderItemID` = $id";

    $myDB->modify($deleteOrderItem);

    header("Location: order-details.php?id=$order&deleted=Order item $id");
  }
?>