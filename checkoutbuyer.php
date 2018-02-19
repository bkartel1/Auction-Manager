<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$errs = array();
$cons = array();
$errs2 = array();
$cons2 = array();

$action = filter_input(INPUT_GET, "action");

if ($action == "paid") { //add/edit lot as paid
  
  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");
   
  }
  
  
  
  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$lotBuyerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi ( paid) ".
              "VALUES ('PAID');");
      if (!$d) array_push ($errs, mysql_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons, "Successfully added lot number ".$lotBuyerID."!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET paid='PAID' WHERE buyer_id='".$lotBuyerID."'");
      $d2 = mysqli_query($connection, "UPDATE $Adb SET paid='PAID' WHERE buyer_id='".$lotBuyerID."'");
      if (!$d) array_push ($errs, "Couldn't update data in database. Please try again.");
      else array_push($cons, "Successfully updated buyer number ".$lotBuyerID." as paid!");
    }
  }
}else if ($action == "unpaid") { //add/edit lot as paid
   $lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");
  
  $lotSellerID = filter_input(INPUT_POST, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotSellerID == false || $lotNumber == NULL) array_push($errs, "A lot must have a seller ID.");
  //$q = mysql_query("SELECT * FROM users WHERE seller_id='".$lotSellerID."';");
  //mysql_num_rows($q);
  //if(mysql_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");
  
  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");
   
  $lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);
  
  
  }
  
  $lotPrice = intval(filter_input(INPUT_POST, "lotPrice", FILTER_SANITIZE_SPECIAL_CHARS));
  
  $lotTitle = filter_input(INPUT_POST, "lotTitle");
  
  
  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$lotBuyerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi ( paid) ".
              "VALUES ('UNPAID');");
      if (!$d) array_push ($errs, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons, "Successfully added lot number ".$lotBuyerID."!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET paid='UNPAID' WHERE buyer_id='".$lotBuyerID."'");
      $d2 = mysqli_query($connection, "UPDATE $Adb SET paid='UNPAID' WHERE buyer_id='".$lotBuyerID."'");
      if (!$d) array_push ($errs, "Couldn't update data in database. Please try again.");
      else array_push($cons, "Successfully updated buyer number ".$lotBuyerID." as UNPAID!");
    }
  }
}

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
	<p>Enter Buyer ID To Checkout Buyer</p>
	<p>Select a lot from below to edit or delete an existing entry.</p>
	<div id="checkoutInfo">
      <form style="display: inline;" action="buyer.php" method="GET">
          <label for="buyerReportID">Buyer ID: </label>
          <input type="text" name="buyerReportID" id="buyerReportID"/>
          <input type="Submit" value="View Individual Report">
        </form>
      </p>
      <p>
		<form style="display: inline;" action="paid.php" method="GET">
		   <label for="lotBuyerID">Buyer ID: </label>
          <input type="text" name="lotBuyerID" id="lotBuyerID"/>
          <div colspan="2" style="display: inline;">
		  <input type="Submit" value="Mark as Paid"/><br/>
        </form>
        </p>
      <p>
		<form style="display: inline;" action="unpaid.php" method="GET">
		   <label for="buyerReportID">Buyer ID: </label>
          <input type="text" name="lotBuyerID" id="lotBuyerID"/>
          <div colspan="2" style="display: inline;">
		  <input type="Submit" value="Mark as UnPaid"/><br/>
        </form>
        </tr>
        </table>
      </form>
        </tr>
        </table>
      </form>
      <p>Select a user from below to get buyers report.</p>
      <div id="ulist">
		  <?php
//var firstName, lastName, userBuyerID, userSellerID, email;
        $userQuery = mysqli_query($connection, "SELECT * from $Adb WHERE buyer_id IS NOT NULL ORDER BY last_name, first_name");
        while ($result = mysqli_fetch_array($userQuery)) {
          $js .= "userBirth.value = '".$result["birth"]."'; ";
          $js .= "userStreet.value = '".$result["street"]."'; ";
          $js .= "userCity.value = '".$result["city"]."'; ";
          $js .= "userState.value = '".$result["state"]."'; ";
          $js .= "userZip.value = '".$result["zip"]."'; ";
          $js .= "userID.value = '".$result["id"]."'; ";
          $js .= "userPhone.value = '".$result["phone"]."'; ";
          $js .= "firstName.value = '".$result["first_name"]."'; ";
          $js .= "lastName.value = '".$result["last_name"]."'; ";
          $js .= "userTax.value = '".$result["tax"]."'; ";
          $js .= "userTaxID.value = '".$result["taxid"]."'; ";
          $js .= "userBuyercomm.value = '".$result["buyer_commission"]."'; ";
          $js .= "userSellercomm.value = '".$result["seller_commission"]."'; ";
          if ($result["buyer_id"]) $js .= "userBuyerID.value = '".$result["buyer_id"]."'; ";
          else $js .= "userBuyerID.value = ''; ";
          if ($result["seller_id"]) $js .= "userSellerID.value = '".$result["seller_id"]."'; ";
          else $js .= "userSellerID.value = ''; ";
          if ($result["email"]) $js .= "userEmail.value = '".$result["email"]."'; ";
          else $js .= "userEmail.value = ''; ";
          echo "        ";
          echo "<div>";
          echo $result["last_name"];
          echo "<span>, </span>";
          echo $result["first_name"];
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo "<span>  Buyer ID:</span>";
          echo $result["buyer_id"];
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo $result["paid"];
          echo "<span class=\"links\">";
          echo "<a href=\"buyer.php?buyerReportID=".$result["buyer_id"]."\">Get Report For Buyer</a>";
          echo "</span>";
          echo "</div>\n";
        }
        //echo "\n";
?>
			
	 </div>

    <footer>
      Christopher Speziali, 2017 This software copyright falls under the MIT
      License, meaning it is provided without warranty of any kind and may be
      modified or redistributed at the will of user. 
    </footer>
  </body>
</html>
<?php
mysqli_close($connection);
?>
