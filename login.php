<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'dbconnector.php';
        $myDB = new Database();
        //Get the username and password from the form.
        $username = $_POST["username"];
        $password = $_POST["password"];
        //Start the session.
        session_start();

        if( isset($username) and isset($password)){
            //Query, if the data was passed, for the employee with the variables.
            $query = "SELECT * FROM employee WHERE username = '$username' AND password = '$password'";
            $emp = $myDB->query($query);
            //If we found only one entry...
            if( $myDB->getNumRows() == 1){
                //Set the session variables and terminate.
                $_SESSION['name'] = $username;
                $_SESSION['employeeID'] = $emp[0]['employeeID'];
                $_SESSION['department'] = $emp[0]['departmentID'];
                header('Location: /admin');
                die();
            }
        }
    }  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>.: Login - TechExpress :.</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <link href="signin.css" rel="stylesheet">

  </head>

  <body>

    <div class="container">
    <br/><br/><br/><br/>
      <form action="login.php" method="POST" class="form-login" role="form">
        <h2 class="form-login-heading">Login</h2>
        <input name="username" type="username" class="form-control" placeholder="Username" required autofocus>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <a href="index.php"> << back</a>
      </form>
    </div>

  </body>
</html>