<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$userLastName = filter_input(INPUT_GET, "last", FILTER_SANITIZE_SPECIAL_CHARS);
$userFirstName = filter_input(INPUT_GET, "first", FILTER_SANITIZE_SPECIAL_CHARS);
$userBirth = filter_input(INPUT_GET, "birth", FILTER_SANITIZE_SPECIAL_CHARS);

$q = mysqli_query($connection, "SELECT * FROM $Adb WHERE first_name='".$userFirstName."' AND last_name='".$userLastName."' And birth='".$userBirth."';");
if ($result = mysqli_fetch_assoc($q)) {
  $q2 = mysqli_query($connection, "SELECT * FROM $Adbi where seller_id='".$result['seller_id']."'");
  $slots = mysqli_num_rows($q2);
  $q3 = mysqli_query($connection, "SELECT * FROM $Adbi where buyer_id='".$result['buyer_id']."'");
  $blots = mysqli_num_rows($q3);
} else { //no such user
  mysqli_close($connection);
  header("Location: ./index.php");
}

mysqli_close($connection);

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Delete User Confirmation</title>
    <link rel="stylesheet" type="text/css" href="./style.css"/>
  </head>
  <body style="font-size: xx-large;">
    <p>Are you sure you want to delete the user <?php echo $userFirstName." ".$userLastName." ".$userBirth;?>?</p>
    <p>Deleting this user will also clear the Seller ID of <?php echo $slots; ?> 
      lots, and the Buyer ID of <?php echo $blots;?> lots.
    </p>
    <form action="register.php?action=deluser" method="POST" style="display: inline;" >
      <input type="hidden" name="userLastName" value="<?php echo $userLastName; ?>"/>
      <input type="hidden" name="userFirstName" value="<?php echo $userFirstName; ?>"/>
      <input type="hidden" name="userBirth" value="<?php echo $userBirth; ?>"/>
      <input style="display: inline;" type="submit" value="Yes I am sure.">
    </form>
    <form  style="display: inline;" action="register.php" method="POST">
      <input style="display: inline;" type="submit" value="Cancel.">
    </form>
  </body>
</html>
