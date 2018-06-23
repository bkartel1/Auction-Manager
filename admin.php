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

    <?php
	include "header.php";
    ?>

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
