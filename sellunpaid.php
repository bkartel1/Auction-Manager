<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$lotSellerID = filter_input(INPUT_GET, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);


$q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id = '".$lotSellerID."';");
if ($result = mysqli_fetch_assoc($q)) {
  $q3 = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id='".$result["seller_id"]."';");
  $blots = mysqli_num_rows($q3);
} else { //no such user
  mysqli_close($connection);
  //header("Location: ./index.php");
}

mysqli_close($connection);

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Paid Confirmation</title>
    <link rel="stylesheet" type="text/css" href="./style.css"/>
  </head>
  <body style="font-size: xx-large;">
    <p>Are you sure you want to mark seller <?php echo $lotSellerID;?> as unpaid #?</p>
    <p>This user sold <?php echo $blots; ?> 
      items.
    </p>
    <form action="checkoutseller.php?action=sellunpaid" method="POST" style="display: inline;" >
      <input type="hidden" name="lotSellerID" value="<?php echo $lotSellerID; ?>"/>
      <input style="display: inline;" type="submit" value="Yes I am sure.">
    </form>
    <form  style="display: inline;" action="checkoutseller.php" method="POST">
      <input style="display: inline;" type="submit" value="Cancel.">
    </form>
  </body>
</html>


