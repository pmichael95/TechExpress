<?php 
  include './components/login-check.php';
  include './components/admin-check.php';
  

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get the employee ID from the header.
    $id = $_GET["id"];
    //Employee of ID 1 cannot be removed (admin)
    if($id == 1){
      header("Location: employees.php?deleted=Failed. The administrator cannot be removed!");
      die();
    }
    //Query to remove the employee of that ID.
    $delete = "DELETE FROM `employee` WHERE `employeeID`=$id";

    $myDB->modify($delete);

    header("Location: employees.php?deleted=$id");
  }
?>