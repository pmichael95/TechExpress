<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get the variable data from the form.
    $productID = $_POST["productID"];
    $discount  = $_POST["discount"];
    //Start date setup format
    $startDate = date('Y-m-d', strtotime($_POST['startDate']));
    //End date setup format
    $endDate = date('Y-m-d', strtotime($_POST['endDate']));

    include '../dbconnector.php';
    $myDB = new Database();
    //Query to add the sale with the variables above.
    $query = "INSERT INTO `techexpress`.`sale`(`saleID`, `productID`, `discount`, `startDate`, `endDate`) VALUES (null,'$productID','$discount','$startDate','$endDate')";

    //---LOG FILE---//
    $logfile ='log.txt';
    $FILEH = fopen($logfile, 'a+') or die("Cannot open $logfile");
    flock($FILEH, LOCK_EX) or die ("Cannot lock file $outf");
    $user = $_SESSION['name'];
    $msg = date('Y-m-d H:i:s')." || $user added a sale: productID[$productID], discount[$discount], startDate[$startDate], endDate[$endDate] \n";
    fputs($FILEH, $msg);
    flock($FILEH,LOCK_UN);
    fclose($FILEH);
    //---LOG FILE---//

    //Run the query
    $myDB->modify($query);

    header("Location: pricing.php?added=A new sale");
  }
?>
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

     <style type="text/css">
    #productForm input, #productForm textarea{
      margin-bottom: 10px;
    }
    </style>

  </head>

  <body>

  <?php 
    include './components/header.php'; 
    include './components/sidebar.php';
  ?>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add a Sale</h1>

            <table>
            <form method="POST" action="add-sale.php">
              <div class="input-group" style="width: 300px">
              <tr>
                <td>
                <label>Start Date</label>
                <input name="startDate" type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
                <br/>
                </td>
              </tr>
              <tr>
                <td>
                <label>End Date</label>
                <input name="endDate" type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>
                <br/>
                </td>
              </tr>
              <tr>
                <td>
                <label>Discount %</label>
                <input name="discount" type="number" class="form-control" value="0" min="0" max="99" required>
                <br/>
                </td>
              </tr>
              </tr>
                <td>
                <label>Product</label>

                  <?php 
                    include '../dbconnector.php';
                    $myDB = new Database();
                    //Query for products.
                    $query = "SELECT * FROM `product`";
                    $prodcuts = $myDB->query($query);

                    if ($prodcuts) {
                      //Give the drop-down list.
                      print '<tr><td><select name="productID">';

                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Add entries to the list.
                        print "<option value='".$prodcuts["$row"]['productID']."'>";
                        print substr($prodcuts["$row"]['productName'], 0, 20);
                        print '</option>';
                      }
                      print '</select></td></tr>';
                    }else { 
                      die ("<b><i>No products found!</i></b>"); 
                    }
                  ?>
                  </td>
              </tr>
              <tr>
                <td>
                <br/>
                <input class="btn btn-default" type="submit" value="Submit">
                </td>
              </tr>
              </div><!-- /input-group -->
            </form>
          </table>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
