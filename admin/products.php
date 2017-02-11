<?php include './components/login-check.php'; ?>

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
         <?php
         //Alert messages for events 
           if (!empty($_GET['added'])) {
                print '<div class=\'alert alert-success\' role=\'alert\'><b>Added: </b><i>' . $_GET["added"] . '</i> to the database! </div>';
           } elseif (!empty($_GET['updated'])) {
                print '<div class=\'alert alert-success\' role=\'alert\'><b>Updated: </b><i>' . $_GET["updated"] . '</i></div>';
           }elseif (!empty($_GET['deleted'])) {
                print '<div class=\'alert alert-danger\' role=\'alert\'><b>Deleted: Product# </b><i>' . $_GET["deleted"] . '</i></div>';
           }
        ?>
          <h1 class="page-header">Products</h1>

          <form action="add-product.php">
            <input type="submit" class="btn btn-default" value="Add">
          </form>

          <br/>
            <?php
              include '../dbconnector.php';
              $myDB = new Database();

              //Query to get the products according to the category
              $query = "SELECT `productID`, `productName`, `productDescription`, 
                                `productPrice`, `productStock`,
                                `soldCount`, `categoryName` 
                            FROM `product`, `category` 
                            WHERE `product`.`categoryID` = `category`.`categoryID`";

              $products = $myDB->query($query);
              if ($products) {
                //Table prints for header
                print '<div class="table-responsive">';
                print '<table class="table table-striped">';
                print '<thead>';
                print '<tr>';
                print '<th>Action</th><th>#</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Sold</th><th>Category</th>';
                print '</tr>';
                print '</thead>';
                print ' <tbody>';
                
                for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                  print '<tr>';
                  //Print the actions.
                  print '<td><a href="edit-product.php?id=' . $products["$row"]['productID'] . '"> 
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                  </a>
                                  <a href="delete-product.php?id=' . $products["$row"]['productID'] . '">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                  </a></td>';

                  //Print out the information within the products returned.
                  foreach($products[$row] as $child) {
                     echo '<td>' . substr($child, 0, 70) . '</td>';
                  }
                  print '</tr>';
                }
                print ' </tbody></table>';
              }else { 
                die ("<b><i>No products found.</i></b>"); 
              }
            ?>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>