<?php 
  include './components/login-check.php';
  include './components/admin-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get variable data from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $salary = $_POST["salary"];
    $departmentID = $_POST["departmentID"];
    $employeeID = $_POST["id"];
    //Run the update for the employee, setting the new values.
    $query = "UPDATE `employee` SET `username`='$username', `password` = '$password', `salary` = $salary, `departmentID` = $departmentID WHERE `employeeID`=$employeeID";
    $myDB->modify($query);
    header("Location: employees.php?updated=$username");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employees</title>

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
          <h1 class="page-header">Edit an Employee</h1>

            <?php

              include '../dbconnector.php';
              $myDB = new Database();
              //Get the ID from the header.
              $employeeID = $_GET["id"];
              //Query with the ID
              $query = "SELECT * FROM `employee` WHERE `employeeID`=$employeeID";

              $emp = $myDB->query($query);
              if ($emp) {
                //Assign them values according to the row returned.
                $cID = $emp[0]['employeeID'];
                $cUserName = $emp[0]['username'];
                $cPassword = $emp[0]['password'];
                $cSalary = $emp[0]['salary'];
                $cDepartmentID = $emp[0]['departmentID'];
              }else { 
                die ("<b><i>No matching employee.</i></b>"); 
              }
            ?>
            <table>
            <form method="POST" action="edit-employee.php">
              <div class="input-group" style="width: 300px">
                <tr>
                  <td>
                    <input name="username" type="text" class="form-control" value="<?php print $cUserName; ?>">
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name="password" type="text" class="form-control" value="<?php print $cPassword; ?>">
                  </td>
                </tr>
                <tr>
                  <td>
                    <input name="salary" type="number" class="form-control" min="0" step="any" value="<?php print $cSalary; ?>">
                  </td>
                </tr>
                <tr>
                  <td>
                    <?php 
                    //Get the departments.
                    $query = "SELECT * FROM `department`";
                    $departments = $myDB->query($query);

                    if ($departments) {
                      //Setup the select drop-down list.
                      print '<tr><td><select name="departmentID">';

                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Print the options.
                        print "<option value='".$departments["$row"]['departmentID']."'>";
                        print $departments["$row"]['departmentName'];
                        print '</option>';
                      }
                      print '</select></td></tr>';
                    }else { 
                      die ("<b><i>No department!</i></b>"); 
                    }
                  ?>
                  </td>
                </tr>
                <tr>
                  <td>
                   <input name="id" type="hidden" value="<?php echo $cID; ?>">
                  </td>
                </tr>
                <tr>
                  <td>
                   <span class="input-group-btn">
                   <input class="btn btn-default" type="submit" value="Update">
                   </span>
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