<?php 
  include './components/login-check.php';
  include './components/admin-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get data from the form.
    $name = $_POST["departmentName"];
    $id = $_POST["id"];

    if($id == 1){
      header("Location: departments.php?updated=Failed. The department cannot be changed!");
      die();
    }
    //Query with the department according to the name.
    $query = "UPDATE `department` SET `departmentName`='$name' WHERE `departmentID`=$id";
    $myDB->modify($query);
    header("Location: departments.php?updated=$name");
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
          <h1 class="page-header">Edit Department</h1>

            <?php

              include '../dbconnector.php';
              $myDB = new Database();
              //Get the department ID.
              $id = $_GET["id"];
              $query = "SELECT * FROM `department` WHERE `departmentID`=$id";

              $categories = $myDB->query($query);
              if ($categories) {
                //Assign values via the returned row.
                $cID = $categories[0]['departmentID'];
                $cName = $categories[0]['departmentName'];
              }else { 
                die ("<b><i>No matching department.</i></b>"); 
              }
            ?>

            <form method="POST" action="edit-department.php">
              <div class="input-group" style="width: 300px">
                <input name="departmentName" type="text" class="form-control" value="<?php echo $cName; ?>">
                <input name="id" type="hidden" value="<?php echo $cID; ?>">
                <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Update">
                </span>
              </div><!-- /input-group -->
            </form>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>