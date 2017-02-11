<?php 
  include 'dbconnector.php';
  $myDB = new Database();
  //Get the product ID from the header.
  $productID = $_GET['id'];
  //Setup the query for entries with that product ID and the respective category.
  $productsQuery = "SELECT `productID`, `productName`, `productDescription`, `productPrice`,
                           `productStock`, `productImage`, `soldCount`, `product`.`categoryID`,
                           `categoryName` 
                        FROM `product`, `category` 
                        WHERE `productID`=$productID 
                        AND `product`.`categoryID` = `category`.`categoryID`";

    $products = $myDB->query($productsQuery);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $products[0]['productName'] ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">
  </head>
  <body>
  
    <?php 
      include 'header.php';
      include 'breadcrumbs.php'; 

      print '<div class="container">';

        if ($products) {
          //Check for the discount using the IDs and the dates according to today.
            $discountCheck = 'SELECT `saleID`, `productID`, `discount`, `startDate`, `endDate` FROM `sale` WHERE `startDate` <= sysdate() AND `endDate` > sysdate() AND `productID` = '.$products["0"]['productID'];
            $discount = $myDB->query($discountCheck);
            
            if($discount){
              //If a discount exists, show the new price.
              $price = '<strike>$'.$products[0]['productPrice'].'</strike> <b class="sale">Sale: $'.$products[0]['productPrice'] * ((100 - $discount[0]['discount']) / 100) .' / '.$discount[0]['discount'].'% off!</b>'; 
            }
            else{
              //Otherwise, show the default.
              $price = '<b>$'.$products[0]['productPrice'].'</b>';
            }
            //Print the product information and image.
            print '<div class="product">';
            print '<img src="'.$products[0]['productImage'].'">';
            print '<h2><a href="product.php?id='.$products[0]['productID'].'">'.$products[0]['productName'].'</a></h2>';            
            print '<span><p>'.$products[0]['productDescription'].'</p>';
            print $price.' / Stock:'.$products[0]['productStock'].' </span>';
            print '</div>';
        }else { 
          echo 'Sorry. There are no products in this category.'; 
        }

        print '</div><!-- /.container -->';
      ?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
