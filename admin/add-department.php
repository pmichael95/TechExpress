<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get the department name from the form.
    $name = $_POST["departmentName"];
    include '../dbconnector.php';
    $myDB = new Database();
    //Insert the data into the department table.
    $query = "INSERT INTO `techexpress`.`department` (`departmentID`, `departmentName`) VALUES (NULL, '$name')";
    $myDB->modify($query);
    header("Location: departments.php?added=$category");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Departments</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/admin/admin.css" rel="stylesheet">
  </head>

  <body>

  <?php 
    include './components/header.php'; 
    include './components/sidebar.php';
  ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add a Department</h1>

            <form method="POST" action="add-department.php">
              <div class="input-group" style="width: 300px">
                <input name="departmentName" type="text" class="form-control" placeholder="Department Name" required>
                <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Add">
                </span>
              </div><!-- /input-group -->
            </form>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>
  </body>
</html>