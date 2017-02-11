<?php
  include './components/login-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get the ID from the header.
    $id = $_GET["id"];
    //The first product cannot be removed.
    if($id == 1){
      header("Location: products.php?deleted=Failed. The default category cannot be deleted!");
      die();
    }
    //Query with that product $id
    $delete = "DELETE FROM `product` WHERE `productID`=$id";

    $myDB->modify($delete);

    header("Location: products.php?deleted=$id");
  }
?>