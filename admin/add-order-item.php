<?php
  include './components/login-check.php';
  $orderID = $_GET["id"];
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get variable data from the form
    $orderID2 = $_POST['orderID2'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    //Query for the stock
    $pStockQ = "SELECT `productStock` FROM `product` WHERE `productID` = $productID";
    $qt = $myDB->query($pStockQ);
    //Get the total quantity from that first query
    $totalQuantity = $qt['0']['productStock'];
    if( $quantity <= $totalQuantity){
      //Insert the order item if the quantity requested is less than the available stock.
      $query2 = "INSERT INTO `techexpress`.`order_item` (`orderID`, `orderItemID`, `productID`, `quantity`) VALUES ($orderID2, NULL, $productID, $quantity)";
      $myDB->modify($query2);
      header("Location: order-details.php?id=$orderID2&added=$productID");
    }
    else{
      header("Location: order-details.php?id=$orderID2&error=Error! The maximum quantity available is $totalQuantity");
    }
  }
?>
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
  </head>

  <body>

  <?php 
    include './components/header.php'; 
    include './components/sidebar.php';
  ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Items to Order #<?php print $orderID; ?></h1>


            <form method="POST" action="add-order-item.php">
              <table>
              <div class="input-group" style="width: 300px">
                   <?php 
                    include '../dbconnector.php';
                    $myDB = new Database();
                    //Query for all products.
                    $query = "SELECT * FROM `product`";
                    $prodcuts = $myDB->query($query);

                    if ($prodcuts) {
                      //Setup the select list
                      print '<tr><td><select name="productID">';

                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Populate it
                        print "<option value='".$prodcuts["$row"]['productID']."'>";
                        print substr($prodcuts["$row"]['productName'], 0, 20);
                        print '</option>';
                      }
                      print '</select></td></tr>';
                    }else { 
                      die ("<b><i>ERROR: No products found.</i></b>"); 
                    }
                  ?> 
                  <tr>
                    <td>
                      <input name="quantity" type="number" class="form-control" placeholder="Enter Quantity" required step='1'>
                    </td>
                  </tr>               
                  <tr>
                  <td>
                    <span class="input-group-btn">
                    <input class="btn btn-default" type="submit" value="Add Order Item">
                    </span>
                  </td>
                  </tr>
                  <tr>
                    <td>
                      <input name="orderID2" type="hidden" class="form-control" value="<?php print $orderID ?>">
                    </td>
                  </tr>   
              </div><!-- /input-group -->
            </table>
            </form>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>