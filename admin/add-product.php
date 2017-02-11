<?php 
    include './components/login-check.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Setup the directories.
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
        //Get variable data from the form.
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $stock = $_POST["stock"];
        $category = $_POST["category"];

        include '../dbconnector.php';
        $myDB = new Database();

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $query = "INSERT INTO `techexpress`.`product`(`productID`, `productName`,
                                  `productDescription`, `productPrice`, `productStock`, 
                                  `productImage`, `soldCount`, `categoryID`) 
                            VALUES (null,'$name','$description',$price,$stock,'/img/products/noimage.jpg',0,$category)";
            $myDB->modify($query);
            header("Location: products.php?added=$product");
            die();
          
        } else {// if everything is ok, try to upload file - to move it from the temp folder to a permanent folder
            if (move_uploaded_file($productImage["tmp_name"], $target_path)) {
      
              $query = "INSERT INTO `techexpress`.`product`(`productID`, `productName`,
                                    `productDescription`, `productPrice`, `productStock`, 
                                    `productImage`, `soldCount`, `categoryID`) 
                              VALUES (null,'$name','$description',$price,$stock,'$target_path_db',0,$category)";
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

    <title>Add Product</title>

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
          <h1 class="page-header">Add Product</h1>

            <form method="POST" action="add-product.php" role="form" id="productForm" enctype="multipart/form-data">
                <table>
                  <tr>
                    <td colspan="2"><label>Name</label><input name="name" type="text" class="form-control" placeholder="Product Name" required></td>
                  </tr>
                  <tr> 
                    <td colspan="2"><label>Description</label><textarea rows="10" name="description" class="form-control"  placeholder="Description" required></textarea></td>
                  </tr>
                  <tr>
                    <td><label>Price</label><input name="price" type="number" class="form-control" placeholder="price" min="0" step="any" required>  </td>
                    <td><label>Stock</label><input name="stock" type="number" class="form-control" placeholder="stock" min="0" required></td>
                  </tr>
                  <?php 
                    include '../dbconnector.php';
                    $myDB = new Database();
                    //Query for all categories.
                    $query = "SELECT * FROM `category`";
                    $categories = $myDB->query($query);

                    if ($categories) {
                      //Table header and select list setup
                      print '<tr><td><label>Category</label><br/><select name="category">';

                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Add options to the list
                        print "<option value='".$categories["$row"]['categoryID']."'>";
                        print $categories["$row"]['categoryName'];
                        print '</option>';
                      }
                      print '</select></td></tr>';
                    }else { 
                      die ("<b><i>No categories found!</i></b>"); 
                    }
                  ?>
                  </tr>
                  <tr>
                        <td><br/><label>Image</label><input type="file" name="productImage" id="productImage"></td>
                  </tr>
                  <tr>
                    <td><br/><input class="btn btn-default" type="submit" value="Add Product"></td>
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