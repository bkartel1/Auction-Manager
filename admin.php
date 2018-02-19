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
	<div id="reportsInfo">
      <p>
        <form style="display: inline;" action="buyer.php" method="GET"><input type="submit" value="View Buyer Reports (All)"/></form> Click To View Report Of All Buyers</p>
        <form style="display: inline;" action="seller.php" method="GET"><input type="submit" value="View Seller Reports (All)"/></form> Click To View Report Of All Sellers</p>
      </p>
      <p>
        <form style="display: inline;" action="overall.php" method="GET"><input type="submit" value="View Overall Report"/></form> Click To View Report Of All Buyers And Sellers</p>
        <form style="display: inline;" action="totalsales.php" method="GET"><input type="submit" value="View Total Sales Report"/></form> Click To View Report Of Total Sales, Tax and Commissions</p>
                <form style="display: inline;" action="unsolditems.php" method="GET"><input type="submit" value="Unsold Items Report"/></form> Click To View Report Of All Unsold Items</p>
        <form style="display: inline;" action="userdisplay.php" method="GET"><input type="submit" value="View All Customers Report"/></form> Click To View Info Of All Customers</p>
        <form style="display: inline;" action="items.php" method="GET"><input type="submit" value="View All Items Report"/></form> Click To View Report Of All Items In This Auction</p>
        <form style="display: inline;" action="reserve.php" method="GET"><input type="submit" value="Reserve Report"/></form> Click To View All Items With Reserve Prices</p>
        <form style="display: inline;" action="absentee.php" method="GET"><input type="submit" value="Absentee Report"/></form> Click To View All Items With Absentee Bids</p>
      </p>
    </div>
		 </div>
		</div>
	  </div>
	</div>
		<div id="toolsInfo">
		<p>Various Auction Tools</p>
		<form style="display: inline;" action="buyercalc.php" method="GET"><input type="submit" value="Buyers Item Calculator"/></form>
		<form style="display: inline;" action="sellercalc.php" method="GET"><input type="submit" value="Sellers Item Calculator"/></form>
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
