<?php include './components/login-check.php'; 
  $orderID = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Order Details</title>

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
                print '<div class=\'alert alert-danger\' role=\'alert\'><b>Deleted: </b><i>' . $_GET["deleted"] . '</i></div>';
           }elseif (!empty($_GET['error'])) {
                print '<div class=\'alert alert-danger\' role=\'alert\'><b>Error: </b><i>' . $_GET["error"] . '</i></div>';
           }
        ?>
          <h1 class="page-header">Order #<?php echo $orderID; ?></h1>

          <form action="add-order-item.php" method="GET">
            <input type="submit" class="btn btn-default" value="Add">
            <input name="id" type="hidden" value="<?php echo $orderID; ?>">
          </form>

          <br/>

            <?php
              include '../dbconnector.php';
              $myDB = new Database();
              //Query to find the order items according to the order ID and product ID.
              $order_items_q = "SELECT `orderItemID`, `orderID`, `quantity`, `productName` 
                                  FROM `order_item`, `product` 
                                  WHERE `orderID` = $orderID
                                  AND `order_item`.`productID` =  `product`.`productID`";

              $order_itmes = $myDB->query($order_items_q);
              if ($order_itmes) {
                //Print out the table header.
                print '<div class="table-responsive">';
                print '<table class="table table-striped">';
                print '<thead>';
                print '<tr>';
                print '<th>Action</th><th>Product</th><th>Quantity</th>';
                print '</tr>';
                print '</thead>';
                print ' <tbody>';
                
                for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                  print '<tr>';
                  //Print out the actions.
                      print '<td><a href="edit-order.php?order='.$orderID.'&id=' . $order_itmes["$row"]['orderItemID'] . '"> 
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                  </a>
                                  <a href="delete-order-item.php?order='.$orderID.'&id=' . $order_itmes["$row"]['orderItemID'] . '">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                  </a></td>';
                     //Print the information.
                     echo '<td>'.$order_itmes["$row"]['productName'].'</td>';
                     echo '<td>'.$order_itmes["$row"]['quantity'].'</td>';
                  print '</tr>';
                }
                print ' </tbody></table>';
              }else { 
                echo "There are no items in this order.";
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