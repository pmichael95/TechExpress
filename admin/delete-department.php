<?php 
  include './components/login-check.php';
  include './components/admin-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get the ID from the header.
    $id = $_GET["id"];

    //The first 2 departments cannot be removed. 
    if($id == 1 OR $id == 2){
      header("Location: departments.php?deleted=Failed. The department cannot be deleted!");
      die();
    }
    //Adjust the products for the 2nd department.
    $fixProducts = "UPDATE `employee` SET `departmentID`= 2 WHERE `departmentID` = $id";
    //Delete the department of that $id
    $delete = "DELETE FROM `department` WHERE `departmentID`=$id";
    //Run the queries.
    $myDB->modify($fixProducts);
    $myDB->modify($delete);

    header("Location: departments.php?deleted=$id");
  }
?>