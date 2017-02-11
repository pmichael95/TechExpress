<ul class="breadcrumb">
	<?php 
	//If on home page, show it.
		if (strpos($_SERVER['PHP_SELF'], 'index.php')){
			print '<li><a href="./index.php">Home</a> <span class="divider"></span></li>';
		}
		//If on a category, add it to the home page too.
		elseif( strpos($_SERVER['PHP_SELF'], 'category.php')){

			print '<li><a href="./index.php">Home</a> <span class="divider"></span></li>
  				  <li class="active">'.$category[0]['categoryName'].'</li>';
		}
		//Add the product with the category and home page before it.
		elseif( strpos($_SERVER['PHP_SELF'], 'product.php')){
			print '<li><a href="./index.php">Home</a> <span class="divider"></span></li>
  				  <li><a href="category.php?id='.$products[0]['categoryID'].'">'.$products[0]['categoryName'].'</a> <span class="divider"></span></li>
  				  <li class="active">'.$products[0]['productName'].'</li>';
		}
	?>
</ul>