<?php include './components/login-check.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pricing</title>

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
                print '<div class=\'alert alert-danger\' role=\'alert\'><b>Deleted: Sale# </b><i>' . $_GET["deleted"] . '</i></div>';
           }
        ?>
          <h1 class="page-header">Pricing</h1>

          <form action="add-sale.php">
            <input type="submit" class="btn btn-default" value="Add a Sale">
          </form>

          <br/>
            <?php
              include '../dbconnector.php';
              $myDB = new Database();
              //Query to get the sales and products according to the ID
              $query = "SELECT `saleID`, `productName`, `discount`, `startDate`, `endDate` FROM `sale`, `product` WHERE `sale`.`productID` = `product`.`productID`";

              $products = $myDB->query($query);
              if ($products) {
                //Initial table header prints.
                print '<div class="table-responsive">';
                print '<table class="table table-striped">';
                print '<thead>';
                print '<tr>';
                print '<th>Action</th><th>#</th><th>Product</th><th>Discount %</th><th>Start Date</th><th>End Date</th>';
                print '</tr>';
                print '</thead>';
                print ' <tbody>';
                
                for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                  print '<tr>';
                  //Print the actions.
                  print '<td><a href="delete-sale.php?id=' . $products["$row"]['saleID'] . '">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                         </a></td>';
                  //Print out the information returned to the table.
                  foreach($products[$row] as $child) {
                     echo '<td>' . substr($child, 0, 70) . '</td>';
                  }
                  print '</tr>';
                }
                print ' </tbody></table>';
              }else { 
                die ("<b><i>No sales at this time.</b></i>"); 
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