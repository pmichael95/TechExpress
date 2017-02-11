<?php include './components/login-check.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Statistics</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/admin/admin.css" rel="stylesheet">
  </head>

  <body>

  <?php 
    include 'components/header.php'; 
    include 'components/sidebar.php';
  ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
           <h1 class="page-header">Statistics</h1>

          <br/>
            <?php
              include '../dbconnector.php';
              $myDB = new Database();
              //Query the product table to get the sold count in order to get the ordering done.
              $orderByStore = "SELECT `productID`, `productName`, `productDescription`, 
                                    `productPrice`, `productStock`,
                                    `soldCount`
                                FROM `product` 
                                ORDER BY `soldCount` DESC";
              //Query to get the order by category ID.
               $orderByCategory = "SELECT `productID`, `productName`, `productDescription`, 
                                        `productPrice`, `productStock`,
                                        `soldCount`, `categoryName`
                                    FROM `product`, `category`
                                    WHERE `product`.`categoryID` = `category`.`categoryID`
                                    ORDER BY `categoryName` DESC, `soldCount` DESC";

              $productsStore = $myDB->query($orderByStore);
              if ($productsStore) {
                //Initial table heading prints.
                print '<div class="table-responsive">';
                print '<table class="table table-striped">';
                print '<caption>Most Popular Products</caption>';
                print '<thead>';
                print '<tr>';
                print '<th>Name</th><th>Sold</th>';
                print '</tr>';
                print '</thead>';
                print ' <tbody>';
                
                for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                  print '<tr>';
                  //Print out the product information.
                  print '<td>'.$productsStore[$row]['productName'].'</td>';
                  print '<td>'.$productsStore[$row]['soldCount'].'</td>';
                  
                  print '</tr>';
                }
                print ' </tbody></table>';
              }else { 
                die ("<b><i>No products loaded.</i></b>"); 
              }

              $productsCategory = $myDB->query($orderByCategory);
              if ($productsCategory) {
                //Initial table print out.
                print '<div class="table-responsive">';
                print '<table class="table table-striped">';
                print '<caption>Most Popular by Category</caption>';
                print '<thead>';
                print '<tr>';
                print '<th>Name</th><th>Category</th><th>Sold</th>';
                print '</tr>';
                print '</thead>';
                print ' <tbody>';
                
                for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                  print '<tr>';
                  //Print the products by category.
                  print '<td>'.$productsCategory[$row]['productName'].'</td>';
                  print '<td>'.$productsCategory[$row]['categoryName'].'</td>';
                  print '<td>'.$productsCategory[$row]['soldCount'].'</td>';
                  
                  print '</tr>';
                }
                print ' </tbody></table>';
              }else { 
                die ("Query=No products found."); 
              }
            ?>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>