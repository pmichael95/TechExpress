<?php
  include './components/login-check.php';
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Get the information from the form.
    $username     = $_POST["username"];
    $password     = $_POST["password"];
    $salary       = $_POST["salary"];
    $departmentID = $_POST["departmentID"];
    include '../dbconnector.php';
    $myDB = new Database();
    //Query to insert the data above into the employee table.
    $query = "INSERT INTO `techexpress`.`employee` (`employeeID`, `username`, `password`, `salary`, `departmentID`) VALUES (NULL, '$username', '$password', $salary, $departmentID)";
    $myDB->modify($query);
    header("Location: employees.php?added=$username");
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
          <h1 class="page-header">Register an Employee</h1>

            <table>
            <form method="POST" action="add-employee.php">
              <div class="input-group" style="width: 300px">
              <tr>
                <td>
                <input name="username" type="text" class="form-control" placeholder="username" required>
                </td>
              </tr>
              <tr>
                <td>
                <input name="password" type="password" class="form-control" placeholder="password" required>
                </td>
              </tr>
              <tr>
                <td>
                <input name="salary" type="number" class="form-control" placeholder="salary" min="0" step="any" required>
                </td>
              </tr>
              </tr>
                  <?php 
                    include '../dbconnector.php';
                    $myDB = new Database();
                    //Get all departments.
                    $query = "SELECT * FROM `department`";
                    $departments = $myDB->query($query);

                    if ($departments) {
                      //Setup the select list.
                      print '<tr><td><select name="departmentID">';

                      for ($row = 0; $row <  $myDB->getNumRows(); $row++) {
                        //Populate it.
                        print "<option value='".$departments["$row"]['departmentID']."'>";
                        print $departments["$row"]['departmentName'];
                        print '</option>';
                      }
                      print '</select></td></tr>';
                    }else { 
                      die ("<b><i>No departments found.</i></b>"); 
                    }
                  ?>
                  </tr>
              <tr>
                <td>
                <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Submit">
                </td>
                </span>
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
    <script src="../js/docs.min.js"></script>
  </body>
</html>