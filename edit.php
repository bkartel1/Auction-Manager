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
