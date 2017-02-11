<?php 
    include './components/login-check.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //SECTION TO UPLOAD IMAGE
    $target_dir = "../img/products/"; //the folder where files will be saved
    $target_dir_db ="/img/products/";
    $allowedTypes = array("jpg", "png", "jpeg", "gif", "bmp");// Allow certain file formats
    $max_upload_bytes = 5000000;

    foreach($_FILES as $key=>$productImage){
      $uploadOk = 1;
      if(isset($productImage)) {
        //Check if image file is a actual image or fake image
        //this is not a guarantee that malicious code may be passed in disguise
        $check = getimagesize($productImage["tmp_name"]);
        if($check !== false) {
          $uploadOk = 1;
        } else {
          $uploadOk = 0;
        }

        $extension = strtolower(pathinfo(basename($productImage["name"]),PATHINFO_EXTENSION));
        $target_file_name = uniqid().'.'.$extension;  
        $target_path = $target_dir . $target_file_name;
        $target_path_db = $target_dir_db . $target_file_name;

        //You may limit the size of the incoming file... Check file size
        if ($productImage["size"] > $max_upload_bytes) {
          $uploadOk = 0;
        }

        // Allow certain file formats
        if(!in_array($extension, $allowedTypes)) {
          $uploadOk = 0;
        }
        //Get the variable data from the form
        $id = $_POST["id"];
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $category = $_POST["category"];

        include '../dbconnector.php';
        $myDB = new Database();

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          $query = "UPDATE `product` SET `productName`='$name', `productDescription`='$description',
                                         `productPrice`=$price,`productStock`=$stock,
                                         `categoryID`=$category
                            WHERE `productID` = $id";

            $myDB->modify($query);
            header("Location: products.php?added=$product");
            die();  
        } else {// if everything is ok, try to upload file - to move it from the temp folder to a permanent folder
            if (move_uploaded_file($productImage["tmp_name"], $target_path)) {
              $query = "UPDATE `product` SET `productName`='$name', `productDescription`='$description',
                                             `productPrice`=$price,`productStock`=$stock,
                                             `categoryID`=$category, `productImage`='$target_path_db'
                            WHERE `productID` = $id";
      
              $myDB->modify($query);
              header("Location: products.php?added=$product");
              die();

            } else {
              echo "Sorry, there was an error uploading your file.";
            }
          }
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Product</title>

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
          <h1 class="page-header">Edit Product</h1>

          <?php

              include '../dbconnector.php';
              $myDB = new Database();
              //Get the ID from the header
              $id = $_GET["id"];
              //Query for products with that ID.
              $query = "SELECT * FROM `product` WHERE `productID`=$id";

              $product = $myDB->query($query);
              if ($product) {
                //Give them values.
                $pID    = $product[0]['productID'];
                $pName  = $product[0]['productName'];
                $pDesc  = $product[0]['productDescription'];
                $pPrice = $product[0]['productPrice'];
                $pStock = $product[0]['productStock'];
                $pImage = $product[0]['productImage'];
                $pCategory = $product[0]['categoryID'];
              }else { 
                die ("<b><i>No products found.</i></b>"); 
              }
            ?>

            <form method="POST" action="edit-product.php" role="form" id="productForm" enctype="multipart/form-data">
                <input name="id" type="hidden" value="<?php echo $pID; ?>">
                <table style="width:500px">
                  <tr>
                    <td colspan="2"><label>Name</label><input name="name" type="text" class="form-control" value="<?php echo "$pName";?>" required></td>
                  </tr>
                  <tr>
                    <td colspan="2"><label>Description</label><textarea rows="10" name="description" class="form-control" required><?php echo "$pDesc";?></textarea></td>
                  </tr>
                  <tr>
                    <td><label>Price</label><input name="price" type="number" class="form-control" value="<?php echo "$pPrice";?>" min="0" step="any" required>  </td>
                    <td><label>Stock</label><input name="stock" type="number" class="form-control" value="<?php echo "$pStock";?>" min="0" required></td>
                  </tr>
                  <?php   
                  //Query for categories.
                    $getCat = "SELECT * FROM `category`";
                    $categories = $myDB->query($getCat);

                    if ($categories) {
                      //Print headers
                      print '<tr><td><label>Category</label> <select name="category">';

                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Print out the options for the categories.
                        if($categories["$row"]['categoryID'] == $pCategory){
                          print "<option value='".$categories["$row"]['categoryID']."' selected='selected'>";
                        }else{
                          print "<option value='".$categories["$row"]['categoryID']."' >";
                        }
                        print $categories["$row"]['categoryName'];
                        print '</option>';
                      }
                      print '</select></td></tr>';
                    }else { 
                      die ("<b><i>No categories found.</i></b>"); 
                    }
                  ?>
                  </tr>
                  <tr>
                        <td><br/>
                        <img width="100px" src="<?php echo $pImage ?>"><br/><br/><input type="file" name="productImage" id="productImage"></td>
                  </tr>
                  <tr>
                    <td><br/><input class="btn btn-default" type="submit" value="Save Changes"></td>
                  </tr>
                </table>
            </form>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>
  </body>
</html>