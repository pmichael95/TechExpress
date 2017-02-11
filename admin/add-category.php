<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get the category from the form
    $category = $_POST["category"];
    include '../dbconnector.php';
    $myDB = new Database();
    //Insert it into the category table.
    $query = "INSERT INTO `techexpress`.`category` (`categoryID`, `categoryName`) VALUES (NULL, '$category')";
    $myDB->modify($query);
    header("Location: categories.php?added=$category");
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
          <h1 class="page-header">Add Category</h1>

            <form method="POST" action="add-category.php">
              <div class="input-group" style="width: 300px">
                <input name="category" type="text" class="form-control" placeholder="Category Name">
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