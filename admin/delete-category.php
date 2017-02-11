<?php
  include './components/login-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get the category's ID from the header
    $id = $_GET["id"];
    //The 1st category cannot be removed.
    if($id == 1){
      header("Location: categories.php?deleted=Failed. The default category cannot be deleted!");
      die();
    }
    //Adjust products to shift to that category of ID 1 by default.
    $fixProducts = "UPDATE `product` SET `categoryID`= 1 WHERE `categoryID` = $id";
    //Delete query of $id
    $delete = "DELETE FROM `category` WHERE `categoryID`=$id";
    //Run them.
    $myDB->modify($fixProducts);
    $myDB->modify($delete);

    header("Location: categories.php?deleted=$id");
  }
?>