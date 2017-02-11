<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get variable data from the form
    $category = $_POST["category"];
    $id = $_POST["id"];

    //The default department cannot be removed.
    if($id == 1){
      header("Location: categories.php?updated=Failed. The default category cannot be changed!");
      die();
    }
    //Run the update with the ID.
    $query = "UPDATE `category` SET `categoryName`='$category' WHERE `categoryID`=$id";
    $myDB->modify($query);
    header("Location: categories.php?updated=$category");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products</title>

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
          <h1 class="page-header">Edit Category</h1>

            <?php

              include '../dbconnector.php';
              $myDB = new Database();
              //Get the ID from the header.
              $id = $_GET["id"];
              //Run a select query with it.
              $query = "SELECT * FROM `category` WHERE `categoryID`=$id";

              $categories = $myDB->query($query);
              if ($categories) {
                //Get the values and assign them to variables.
                $cID = $categories[0]['categoryID'];
                $cName = $categories[0]['categoryName'];
              }else { 
                die ("<b><i>No category found.</i></b>"); 
              }
            ?>

            <form method="POST" action="edit-category.php">
              <div class="input-group" style="width: 300px">
                <input name="category" type="text" class="form-control" value="<?php echo $cName; ?>">
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