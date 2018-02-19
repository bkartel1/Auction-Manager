<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$errs = array();
$cons = array();
$errs2 = array();
$cons2 = array();

$action = filter_input(INPUT_GET, "action");


?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Speziali Auction Database Management</title>
    <link rel="stylesheet" type="text/css" href="./style.css"/>
    <script type="text/javascript" src="./forms.js"></script>
  </head>
  <body onload="onLoadFunction();">
    <header>Speziali Auction Database Management</header>
    <span>Font Size:</span>
    <div id="fontButtonContainer">
      <div id="smallFont" class="minibutton">A</div>
      <div id="medFont" class="minibutton">A</div>
      <div id="bigFont" class="minibutton">A</div>
    </div>
    <p> </p>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="icon-bar">
	<a class="active" href="index.php"><i class="fa fa-home"></i></a><p>&nbspCurrent Auction <?php echo $Auction ?> </p>
	</div>
    <?php
    if (count($errs) > 0) {
      echo "<div id=\"err\">\n";
      while ($res = array_pop($errs)) {
        echo "      <p>" . $res. "</p>\n";
      }
      echo "</div>";
    }

    if (count($cons) > 0) {
      echo "<div id=\"confirm\">\n";
      while ($res = array_pop($cons)) {
        echo "      <p>" . $res. "</p>\n";
      }
      echo "</div>";
    }

    echo "\n";
    ?>

    <p>Select A Tab From Below To Manage Auction</p>
     <div class="topnav" id="myTopnav">
  <a href="register.php">Register User</a>
  <a href="lots.php">Add/Edit Lots</a>
  <a href="checkoutbuyer.php">Checkout Buyer</a>
  <a href="checkoutseller.php">Checkout Seller</a>
  <a href="admin.php">Reports and Tools</a>
  <a href="edit.php">Edit Users and Lots</a>
	</div>
	</div>
	<div>
    <p><b style="color: red;">Please use caution!</b><b> No actions can be undone if you delete any users or items when using these forms!</b></p>
      <p>
        <form style="display: inline;" action="editlots.php" method="GET"><input type="submit" value="Edit and Delete Lots"/></form> Click To Edit or Delete Any Lots Entered</p>
        <form style="display: inline;" action="editcustomer.php" method="GET"><input type="submit" value="Edit Current Customers"/></form> Click To Edit Customers In Current Auction Only!</p>
      </p>
      <p>
        <form style="display: inline;" action="editmaster.php" method="GET"><input type="submit" value="Edit and Delete from Master Database"/></form> Click To Edit or Delete Customers From Master Database</p>
      </p>
    </div>
		 </div>
		</div>
	  </div>
	</div>
    <footer>
      Christopher Speziali, 2017 This software copyright falls under the MIT
      License, meaning it is provided without warranty of any kind and may be
      modified or redistributed at the will of user.
    </footer>
  </body>
</html>
<?php
mysql_close($connection);
?>
