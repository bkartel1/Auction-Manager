<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$errs = array();
$cons = array();
$errs2 = array();
$cons2 = array();

$action = filter_input(INPUT_GET, "action");

if ($action == "sellpaid") { //add/edit seller as paid
   $lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");
  
  $lotSellerID = filter_input(INPUT_POST, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotSellerID == false || $lotNumber == NULL) array_push($errs, "A lot must have a seller ID.");
  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$lotSellerID."';");
  mysqli_num_rows($q);
  if(mysqli_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");
  
  $lotSellercheckID = filter_input(INPUT_POST, "lotSellercheckID", FILTER_SANITIZE_SPECIAL_CHARS);
  
  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");
   
  $lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);
  
  
  }
  
  $lotPrice = intval(filter_input(INPUT_POST, "lotPrice", FILTER_SANITIZE_SPECIAL_CHARS));
  
  $lotTitle = filter_input(INPUT_POST, "lotTitle");
  
  
  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id='".$lotSellerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi ( paid) ".
              "VALUES ('PAID');");
      if (!$d) array_push ($errs, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons, "Successfully updated seller".$lotSellerID."to paid!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET seller_paid='PAID' WHERE seller_id='".$lotSellerID."'");
      $d2 = mysqli_query($connection, "UPDATE $Adb SET seller_paid='PAID' WHERE seller_id='".$lotSellerID."'");
      $d3 = mysqli_query($connection, "UPDATE $Adb SET seller_check='".$lotSellercheckID."' WHERE seller_id='".$lotSellerID."'");
      if (!$d) array_push ($errs, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      if (!$d2) array_push ($errs, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      if (!$d3) array_push ($errs, "Couldn't update check in database. Please try again." .mysqli_error($connection));
      else array_push($cons, "Successfully updated seller number ".$lotSellerID." as paid!");
    }
  }
}else if ($action == "sellunpaid") { //add/edit seller as paid
   $lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");
  
  $lotSellerID = filter_input(INPUT_POST, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotSellerID == false || $lotNumber == NULL) array_push($errs, "A lot must have a seller ID.");
  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$lotSellerID."';");
  mysqli_num_rows($q);
  if(mysqli_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");
  
  $lotSellercheckID = filter_input(INPUT_POST, "lotSellercheckID", FILTER_SANITIZE_SPECIAL_CHARS);
  
  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");
   
  $lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);
  
  
  }
  
  $lotPrice = intval(filter_input(INPUT_POST, "lotPrice", FILTER_SANITIZE_SPECIAL_CHARS));
  
  $lotTitle = filter_input(INPUT_POST, "lotTitle");
  
  
  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id='".$lotSellerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi ( paid) ".
              "VALUES ('UNPAID');");
      if (!$d) array_push ($errs, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons, "Successfully updated seller" .$lotSellerID."to UNPAID!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET seller_paid='UNPAID' WHERE seller_id='".$lotSellerID."'");
      $d2 = mysqli_query($connection, "UPDATE $Adb SET seller_paid='UNPAID' WHERE seller_id='".$lotSellerID."'");
      $d3 = mysqli_query($connection, "UPDATE $Adb SET seller_check='' WHERE seller_id='".$lotSellerID."'");
      if (!$d) array_push ($errs, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      if (!$d2) array_push ($errs, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      if (!$d3) array_push ($errs, "Couldn't update check in database. Please try again." .mysqli_error($connection));
  else array_push($cons, "Successfully updated seller number ".$lotSellerID." as UNPAID!");
    }
  }
}else if ($action == "sellsetup") { //add/edit user
	
  $userSellerID = filter_input(INPUT_POST, "userSellerID", FILTER_SANITIZE_SPECIAL_CHARS);

  $userSetup = filter_input(INPUT_POST, "userSetup", FILTER_SANITIZE_SPECIAL_CHARS);


  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$userSellerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adb (setup) VALUES ('".$userSetup."');");
      if (!$d) array_push ($errs, "Couldn't insert setup fee into database. Please try again." .mysqli_error($connection));
      else array_push($cons, "Successfully added setup fee!");
      }if(mysqli_num_rows($q1) == 0) {
	  $d = mysqli_query($connection, "UPDATE $Adb SET 
              setup='".$userSetup."' WHERE seller_id='".$userSellerID."'");
       if (!$d) array_push ($errs, "Couldn't update setup fee in database. Please try again." .mysqli_error($connection));
      else array_push($cons, "Successfully updated setup fee!");

    }
  }
}else if ($action == "selldisposal") { //add/edit user
	
  $userSellerID = filter_input(INPUT_POST, "userSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  
  $userDisposal = filter_input(INPUT_POST, "userDisposal", FILTER_SANITIZE_SPECIAL_CHARS);
  
  $userDisNotes = filter_input(INPUT_POST, "userDisNotes", FILTER_SANITIZE_SPECIAL_CHARS);


  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$userSellerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adb (disposal, disposal_note) VALUES ('".$userDisposal."','".$userDisNotes."');");
      if (!$d) array_push ($errs, "Couldn't insert disposal fee into database. Please try again." .mysqli_error($connection));
      else array_push($cons, "Successfully added disposal fee!");
      }if(mysqli_num_rows($q1) == 0) {
	  $d = mysqli_query($connection, "UPDATE $Adb SET 
              disposal='".$userDisposal."', disposal_note='".$userDisNotes."' WHERE seller_id='".$userSellerID."'");
       if (!$d) array_push ($errs, "Couldn't update disposal fee in the database. Please try again." .mysqli_error($connection));
      else array_push($cons, "Successfully updated disposal fee!");

    }
  }
}

?><!DOCTYPE html>

    <?php
    include "header.php";
    
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

	<p>Enter seller id below to view sales report.</p>
	<div class= id="checkoutsellInfo">
      <form style="display: inline;" action="seller.php" method="GET">
          <label for="sellerReportID">Seller ID: </label>
          <input type="text" name="sellerReportID" id="sellerReportID"/>
          <input type="Submit" value="View Individual Report">
        </form>
      </p>
      <p>
		<form style="display: inline;" action="sellpaid.php" method="GET">
			<p>Enter a seller id and check number to mark a seller as paid.</p>
		   <label for="sellerReportID">Seller ID: </label>
          <input type="text" name="lotSellerID" id="lotSellerID"/>
          <label for="sellerReportID">Check #: </label>
          <input type="text" name="lotSellercheckID" id="lotSellercheckID"/>
          <div colspan="2" style="display: inline;">
		  <input type="Submit" value="Mark Seller as Paid"/><br/>
        </form>
        </p>
      <p>
		<form style="display: inline;" action="sellunpaid.php" method="GET">
			<p>Enter a seller id to mark seller as unpaid.</p>
		   <label for="sellerReportID">Seller ID: </label>
          <input type="text" name="lotSellerID" id="lotSellerID"/>
          <div colspan="2" style="display: inline;">
		  <input type="Submit" value="Mark Seller as UnPaid"/><br/>
        </form>
       </p>
      <p>
       <form action="checkoutseller.php?action=sellsetup" method="POST">
		   <p>Apply Seller Fees Below</p>
		  <tr>
			  <p>Setup Fee</p>
		   <td><label for="userSellerID">Seller ID: </label></td>
           <td><input type="text" size="4" name="userSellerID" id="userSellerID"/></td>
		   <td><label for="userSetup">Setup Fee: </label></td>
           <td><input type="text" size="4" name="userSetup" id="userSetup"/></td>
           <td colspan="2" style="display: inline;">
		   <input type="Submit" value="Add Setup Fee"/><br/>
          </tr>
          </form>
        </p>
          <form action="checkoutseller.php?action=selldisposal" method="POST">
		   <p>Disposal Fee</p>
		  <tr>
		   <td><label for="userSellerID">Seller ID: </label></td>
           <td><input type="text" size="4" name="userSellerID" id="userSellerID"/></td>
           <td><label for="userDisposal">Disposal Fee: </label></td>
           <td><input type="text" size="4" name="userDisposal" id="userDisposal"/></td>
           <td><label for="userDisNotes">Disposal Notes: </label></td>
           <td><input type="text" name="userDisNotes" id="userDisNotes"/></td>
           <td colspan="2" style="display: inline;">
		   <input type="Submit" value="Add Seller Fees"/><br/>
		  </tr>
        </form>
       </p>
        </table>
        </tr>
      </form>
      <p>Select a seller from below to get sellers report.</p>
      <div id="ulist">
		  <?php
//var firstName, lastName, userBuyerID, userSellerID, email;
        $userQuery = mysqli_query($connection, "SELECT * from $Adb WHERE seller_id IS NOT NULL ORDER BY last_name, first_name");
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
          echo "<span>  Seller ID:</span>";
          echo $result["seller_id"];
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo $result["seller_paid"];
          echo "<span class=\"links\">";
          echo "<a href=\"seller.php?sellerReportID=".$result["seller_id"]."\">Get Report For Seller</a>";
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
