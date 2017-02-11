<?php
  include './components/login-check.php';

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    include '../dbconnector.php';
    $myDB = new Database();
    //Get the ID from the header.
    $id = $_GET["id"];
    //Setup the query to delete the sale's ID according to the $id
    $delete = "DELETE FROM `sale` WHERE `saleID`=$id";
    //---LOG FILE---//
    $logfile ='log.txt';
    $FILEH = fopen($logfile, 'a+') or die("Cannot open $logfile");
    flock($FILEH, LOCK_EX) or die ("Cannot lock file $outf");
    $user = $_SESSION['name'];
    $msg = date('Y-m-d H:i:s')." || $user deleted a sale: saleID[$id] \n";
    fputs($FILEH, $msg);
    flock($FILEH,LOCK_UN);
    fclose($FILEH);
    //---LOG FILE---//
    //Execute the query
    $myDB->modify($delete);

    header("Location: pricing.php?deleted=$id");
  }
?>