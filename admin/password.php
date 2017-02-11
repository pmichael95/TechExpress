<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get data from the form
    $old     = $_POST["old"];
    $new     = $_POST["new"];
    $confirm = $_POST["confirm"];
    $id      = $_POST["id"];
    //Query to find the old password.
    $oldPasswordQ = "SELECT * FROM `employee` WHERE `employeeID`=$id";
    $oldPassword = $myDB->query($oldPasswordQ);
    //Check if the old passwords match.
    if($old == $oldPassword[0]['password']){
      if($new == $confirm){
        //Query to update the password.
        $query = "UPDATE `employee` SET `password`='$new' WHERE `employeeID`=$id";
        $myDB->modify($query);
        header("Location: password.php?success=Password changed!");
      }else{
        header("Location: password.php?failed=Passwords do not match!");
      }
    }else{
      header("Location: password.php?failed=Wrong password!");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products</title>

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
        <?php 
        //Alert messages for events 
          if (!empty($_GET['failed'])) {
                  print '<div class=\'alert alert-danger\' role=\'alert\'><b>Failed: </b>' . $_GET["failed"] . ' </div>';
          }
          if (!empty($_GET['success'])) {
                  print '<div class=\'alert alert-success\' role=\'alert\'><b>Success: </b>' . $_GET["success"] . ' </div>';
          }
        ?>
          <h1 class="page-header">Change Password</h1>

            <form method="POST" action="password.php">
              <div class="input-group" style="width: 300px">
              <div class="form-group">
                <label>Old Password</label>
                <input name="old" type="password" class="form-control" required>
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input name="new" type="password" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Confirmation</label>
                <input name="confirm" type="password" class="form-control" required>
              </div>
                <input name="id" type="hidden" value="<?php echo $_SESSION['employeeID'] ?>">
                <input class="btn btn-default" type="submit" value="Update">
              </div><!-- /input-group -->
            </form>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>