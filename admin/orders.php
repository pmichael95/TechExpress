<?php include './components/login-check.php'; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Orders</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/admin/admin.css" rel="stylesheet">

    <style type="text/css">
      .table{
        width: 0;
      }
    </style>
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
                print '<div class=\'alert alert-danger\' role=\'alert\'><b>Deleted: Order# </b><i>' . $_GET["deleted"] . '</i></div>';
           }
        ?>
          <h1 class="page-header">Orders</h1>

          <form action="add-order.php">
            <input type="submit" class="btn btn-default" value="Add Order">
          </form>

          <br/>

            <?php
              include '../dbconnector.php';
              $myDB = new Database();

              //Query to get the orders and the employee name who created the order
              $query = "SELECT `orderID`, `username`, `orderDate` 
                          FROM `order`, `employee` 
                          WHERE `order`.`employeeID` = `employee`.`employeeID`";

              $orders = $myDB->query($query);
              if ($orders) {
                print '<div class="table-responsive">';
                print '<table class="table table-striped">';
                print '<thead>';
                print '<tr>';
                print '<th>Action</th><th>Order #</th><th>Created By</th><th>Date Placed</th>';
                print '</tr>';
                print '</thead>';
                print ' <tbody>';
                
                for ($row = 0; $row < $myDB->getNumRows(); $row++) {
                  print '<tr>';
                  if($orders["$row"]['orderID'] != 'Uncategorized'){
                      print '<td><a href="order-details.php?id=' . $orders["$row"]['orderID'] . '"> 
                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                  </a>
                                  <a href="delete-order.php?id=' . $orders["$row"]['orderID'] . '">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                  </a>
                                  </td>';
                  }
                  else{
                    print '<td> </td>';
                  }
                  //Print the order details
                  foreach($orders[$row] as $child) {
                     echo '<td>' . substr($child, 0, 100) . '</td>';
                  }
                  print '</tr>';
                }
                print ' </tbody></table>';
              }else { 
                print '<b><i>No orders available.</i></b>'; 
              }
            ?>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>
  </body>
</html>