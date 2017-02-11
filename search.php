<?php 
  include 'dbconnector.php';
  $myDB = new Database();
  //Get the keyword from the header.
  $keyword = $_GET['q'];
  //Explode the keyword to allow multiple words.
  $keywords = explode(" ", $keyword);
  $sqlLike = "";

  for($i = 0; $i < count($keywords); ++$i) {
    //Go through a loop and add to the query variable for the WHERE clause.
      $sqlLike .=  " productName LIKE '%$keywords[$i]%' OR productDescription LIKE '%$keywords[$i]%' ";
      if($i != count($keywords)-1 ){
        $sqlLike .= "OR";
      }
  }
  //Complete the query variable.
  $searchProducts = "SELECT * FROM product WHERE $sqlLike";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $keyword; ?></title>

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

      print "<div class='page-header'><h1>Search: $keyword </h1></div>";
      //Query with the setup query variable.
      $products = $myDB->query($searchProducts);
      $productCount = $myDB->getNumRows();

      if ($products) {
        
        for ($row = 0; $row < $productCount ; $row++) {
          //If rows were found, go through them.
          //Check if a discount exists on that product.
          $discountCheck = 'SELECT `saleID`, `productID`, `discount`, `startDate`, `endDate` FROM `sale` WHERE `startDate` <= sysdate() AND `endDate` > sysdate() AND `productID` = '.$products["$row"]['productID'];
          $discount = $myDB->query($discountCheck);
          
          if($discount){
            //If yes, show the new price.
            $price = '<strike>$'.$products["$row"]['productPrice'].'</strike> <b class="sale">Sale: $'.$products["$row"]['productPrice'] * ((100 - $discount[0]['discount']) / 100) .' / '.$discount[0]['discount'].'% off!</b>'; 
          }
          else{
            //If no, show the normal price.
            $price = '<b>$'.$products["$row"]['productPrice'].'</b>';
          }
          //Print the information and image for the products.
          print '<div class="product">';
          print '<img src="'.$products["$row"]['productImage'].'">';
          print '<h2><a href="product.php?id='.$products["$row"]['productID'].'">'.$products["$row"]['productName'].'</a></h2>';            print '<span><p>'.$products["$row"]['productDescription'].'</p>';
          print $price.' / Stock:'.$products["$row"]['productStock'].' </span>';
          print '</div>';
        }
      }else { 
        die ("Sorry. There no results for this search query."); 
      }

        print '</div><!-- /.container -->';
      ?>
  </body>
</html>
