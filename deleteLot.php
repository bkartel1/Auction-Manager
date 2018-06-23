<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$itemNumber = filter_input(INPUT_GET, "no", FILTER_SANITIZE_SPECIAL_CHARS);

$q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE itemnum='".$itemNumber."';");
if (!$result = mysqli_fetch_assoc($q)) {
  mysqli_close($connection);
  header("Location: ./index.php");
}

mysqli_close($connection);

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Delete Lot Confirmation</title>
    <link rel="stylesheet" type="text/css" href="./style.css"/>
  </head>
  <body style="font-size: xx-large;">
    <p>Are you sure you want to delete the lot <?php echo $itemNumber;?>?</p>
    <form action="edit.php?action=dellot" method="POST" style="display: inline;" >
      <input type="hidden" name="itemNumber" value="<?php echo $itemNumber; ?>"/>
      <input style="display: inline;" type="submit" value="Yes I am sure.">
    </form>
    <form  style="display: inline;" action="edit.php" method="POST">
      <input style="display: inline;" type="submit" value="Cancel.">
    </form>
  </body>
</html>

