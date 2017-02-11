<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get variable data from the form.
    $quantity      = $_POST["quantity"];
    $productStock  = $_POST["productStock"];
    $orderItemID   = $_POST["orderItemID"];
    $productName   = $_POST["productName"];
    $orderID       = $_POST["orderID"];

    //Make sure the requested quantity isn't greater than the avaiable quantity.
    if($quantity > $productStock){
      header("Location: orders.php?updated=The order item quantity could not be modified.");
      die();
    }
    //Run an update query to change the quantities.
    $query = "UPDATE `techexpress`.`order_item` SET `quantity`='$quantity' WHERE `order_item`.`orderItemID`=$orderItemID";
    $myDB->modify($query);
    header("Location: order-details.php?id=$orderID&updated=Quantity for $productName");
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
          <h1 class="page-header">Edit Order Item's Quantity</h1>

            <?php

              include '../dbconnector.php';
              $myDB = new Database();
              //Get the order item's ID and the order ID from the header.
              $id = $_GET["id"];
              $orderID = $_GET["order"];
              //Query with the values.
              $query = "SELECT * FROM `order_item` WHERE `orderItemID`=$id";

              $orders = $myDB->query($query);
              if ($orders) {
                //Set the variable data from it.
                $quantity     = $orders[0]['quantity'];
                $productID    = $orders[0]['productID'];
                //Query for all products with that ID.
                $query2       = "SELECT * FROM `product` WHERE `productID` = $productID";
                $products     = $myDB->query($query2);
                if( $products ){
                  //Give the products their values in a variable.
                  $productName  = $products[0]['productName'];
                  $productStock = $products[0]['productStock'];
                }
                else{
                  die ("<b><i>Product not found.</i></b>");
                }
              }else { 
                die ("<b><i>Order not found.</i></b>"); 
              }
            ?>
            <form method="POST" action="edit-order.php">
            <table>
              <div class="input-group" >
                <td>
                  <tr>
                    <label for="quantity">Editing quantity for: 
                      <?php 
                        print '<font color="green">'.$productName.'</font>' or die(" undefined item.");
                      ?>
                    </label>
                  </tr>
                </td>
                  <tr>
                    <td><input id="quantity" name="quantity" type="number" class="form-control" value="<?php echo $quantity; ?>" required step="1"></td>
                    <input name="productStock" type="hidden" value="<?php echo $productStock; ?>">
                    <input name="orderItemID" type="hidden" value="<?php echo $id; ?>">
                    <input name="productName" type="hidden" value="<?php echo $productName; ?>">
                    <input name="orderID" type="hidden" value="<?php echo $orderID; ?>">
                  </tr>
                  <tr>
                    <td>
                    <br/>
                    <span class="input-group-btn">
                    <input class="btn btn-default" type="submit" value="Update">
                    </span>
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