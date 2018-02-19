<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$lotBuyerID = filter_input(INPUT_GET, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);


$q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id = '".$lotBuyerID."';");
if ($result = mysqli_fetch_assoc($q)) {
  $q3 = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$result["buyer_id"]."';");
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
    <p>Are you sure you want to mark buyer <?php echo $lotBuyerID;?> as unpaid?</p>
    <p>This user bought <?php echo $blots; ?> 
      items.
    </p>
    <form action="checkoutbuyer.php?action=unpaid" method="POST" style="display: inline;" >
      <input type="hidden" name="lotBuyerID" value="<?php echo $lotBuyerID; ?>"/>
      <input style="display: inline;" type="submit" value="Yes I am sure.">
    </form>
    <form  style="display: inline;" action="checkoutbuyer.php" method="POST">
      <input style="display: inline;" type="submit" value="Cancel.">
    </form>
  </body>
</html>
