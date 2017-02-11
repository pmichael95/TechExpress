<?php 
  include 'dbconnector.php';
  $myDB = new Database();
  //Get the category ID from the header.
  $categoryID = $_GET['id'];
  //Query for the category name with that ID.
  $categoryQuery = "SELECT `categoryName` FROM `category` WHERE `categoryID`=$categoryID";
  //Find products with that category ID.
  $productsQuery = "SELECT * FROM `product` WHERE `categoryID`=$categoryID ORDER BY `soldCount` DESC";
  //Create the variable holding the data from the query.
  $category = $myDB->query($categoryQuery);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $category[0]['categoryName']; ?></title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
  
    <?php 
      include 'header.php';
      include 'breadcrumbs.php'; 

      print '<div class="container">';

      print "<div class='page-header'><h1>".$category[0]['categoryName']."</h1></div>";
      //Query for the products.
        $products = $myDB->query($productsQuery);
        //Get the row count.
        $productCount = $myDB->getNumRows();

        if ($products) {
          
          for ($row = 0; $row < $productCount ; $row++) {
           //Query for the discounts 
            $discountCheck = 'SELECT `saleID`, `productID`, `discount`, `startDate`, `endDate` FROM `sale` WHERE `startDate` <= sysdate() AND `endDate` > sysdate() AND `productID` = '.$products["$row"]['productID'];
            $discount = $myDB->query($discountCheck);
            
            if($discount){
              //If a discount exists, show the modified price with the format.
              $price = '<strike>$'.$products["$row"]['productPrice'].'</strike> <b class="sale">Sale: $'.$products["$row"]['productPrice'] * ((100 - $discount[0]['discount']) / 100) .' / '.$discount[0]['discount'].'% off!</b>'; 
            }
            else{
              //Otherwise, show the default.
              $price = '<b>$'.$products["$row"]['productPrice'].'</b>';
            }
            //Show the image and a link to its product page.
            print '<div class="product">';
            print '<img src="'.$products["$row"]['productImage'].'">';
            print '<h2><a href="product.php?id='.$products["$row"]['productID'].'">'.$products["$row"]['productName'].'</a></h2>';            print '<span><p>'.$products["$row"]['productDescription'].'</p>';
            print $price.' / Stock:'.$products["$row"]['productStock'].' </span>';
            print '</div>';
          }
        }else { 
          die ("<b><i>Sorry. There are no products in this category.</b></i>"); 
        }

        print '</div><!-- /.container -->';
      ?>
  </body>
</html>
