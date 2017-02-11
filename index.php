<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechExpress</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
  </head>
  <body>
  
    <?php 
      include 'dbconnector.php';
      $myDB = new Database();

      include 'header.php';
      include 'breadcrumbs.php'; 

      print '<div class="container">';
        //Query for the products ordered by their soldcount.
        $query = "SELECT * FROM `product` ORDER BY `soldCount` DESC";

        $products = $myDB->query($query);
        $productCount = $myDB->getNumRows();
        if ($products) {
          
          for ($row = 0; $row < $productCount ; $row++) {
            //Query for discounts.
            $discountCheck = 'SELECT `saleID`, `productID`, `discount`, `startDate`, `endDate` FROM `sale` WHERE `startDate` <= sysdate() AND `endDate` > sysdate() AND `productID` = '.$products["$row"]['productID'];
            $discount = $myDB->query($discountCheck);
            
            if($discount){
              //If a discount exists (sale), show the new price.
              $price = '<strike>$'.$products["$row"]['productPrice'].'</strike> <b class="sale">Sale: $'.$products["$row"]['productPrice'] * ((100 - $discount[0]['discount']) / 100) .' / '.$discount[0]['discount'].'% off!</b>'; 
            }
            else{
              //Otherwise, show the default.
              $price = '<b>$'.$products["$row"]['productPrice'].'</b>';
            }
            //Print the information.
            print '<div class="product">';
            print '<img src="'.$products["$row"]['productImage'].'">';
            print '<h2><a href="product.php?id='.$products["$row"]['productID'].'">'.$products["$row"]['productName'].'</a></h2>';
            print '<span><p>'.$products["$row"]['productDescription'].'</p>';
            print $price.' / Stock:'.$products["$row"]['productStock'].' </span>';
            print '</div>';
          }
        }else { 
          die ("<b><i>Cannot load products at this time.</b></i>"); 
        }

        print '</div><!-- /.container -->';
      ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
