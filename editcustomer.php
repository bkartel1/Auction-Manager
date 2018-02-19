<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$errs = array();
$cons = array();
$errs2 = array();
$cons2 = array();

$action = filter_input(INPUT_GET, "action");

if ($action == "user") { //add/edit user
  $userFirstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userFirstName == false || $userFirstName == NULL) array_push($errs, "A first name is required.");

  $userLastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userLastName == false || $userLastName == NULL) array_push($errs, "A last name is required.");

  $userBirth = filter_input(INPUT_POST, "userBirth", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userBirth == false || $userBirth == NULL) array_push($errs, "A date of birth is required.");

  $userStreet = filter_input(INPUT_POST, "userStreet", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userStreet == false || $userStreet == NULL) array_push($errs, "A street is required.");

  $userCity = filter_input(INPUT_POST, "userCity", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userCity == false || $userCity == NULL) array_push($errs, "A city is required.");

  $userState = filter_input(INPUT_POST, "userState", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userState == false || $userState == NULL) array_push($errs, "A state is required.");

  $userZip = filter_input(INPUT_POST, "userZip", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userZip == false || $userZip == NULL) array_push($errs, "A zip code is required.");

  $userPhone = filter_input(INPUT_POST, "userPhone", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userPhone == false || $userPhone == NULL) array_push($errs, "A phone number is required.");

  $userSellerID = filter_input(INPUT_POST, "userSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  //TODO check duplicate SID and BID in users!

  $userBuyerID = filter_input(INPUT_POST, "userBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);

  $userID = filter_input(INPUT_POST, "userID", FILTER_SANITIZE_SPECIAL_CHARS);

  $userTaxID = filter_input(INPUT_POST, "userTaxID", FILTER_SANITIZE_SPECIAL_CHARS);

  $userTax = filter_input(INPUT_POST, "userTax", FILTER_SANITIZE_SPECIAL_CHARS);

  $userSellercomm = filter_input(INPUT_POST, "userSellercomm", FILTER_SANITIZE_SPECIAL_CHARS);

  $userBuyercomm = filter_input(INPUT_POST, "userBuyercomm", FILTER_SANITIZE_SPECIAL_CHARS);

  $userNotes = filter_input(INPUT_POST, "userNotes", FILTER_SANITIZE_SPECIAL_CHARS);

  $userSetup = filter_input(INPUT_POST, "userSetup", FILTER_SANITIZE_SPECIAL_CHARS);

  $userDisposal = filter_input(INPUT_POST, "userDisposal", FILTER_SANITIZE_SPECIAL_CHARS);

  $userDisNotes = filter_input(INPUT_POST, "userDisNotes", FILTER_SANITIZE_SPECIAL_CHARS);

  $userNum = filter_input(INPUT_POST, "userNum", FILTER_SANITIZE_SPECIAL_CHARS);

  if (!$userSellerID && !$userBuyerID) array_push($errs, "A user should have a Buyer ID or a Seller ID or both.");

  $userEmail = filter_input(INPUT_POST, "userEmail", FILTER_SANITIZE_EMAIL);


  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE usernum='".$userNum."';");
    //$q1 = mysqli_query($connection, "SELECT * FROM masterusers WHERE first_name='".$userFirstName."' AND last_name='".$userLastName."' AND birth='".$userBirth."';");
    if(mysqli_num_rows($q) == 0) {
      //$d = mysqli_query($connection, "INSERT INTO $Adb (first_name, last_name, birth, street, city, state, zip, id, phone, buyer_id, seller_id, email, tax, taxid, buyer_commission, seller_commission, paid, seller_paid, notes, setup, disposal, disposal_note) VALUES ('".$userFirstName."','".$userLastName."', '".$userBirth."', //'".$userStreet."','".$userCity."','".$userState."','".$userZip."','".$userID."','".$userPhone."',IF('".$userBuyerID."'='',NULL,'".$userBuyerID."'),IF('".$userSellerID."'='',NULL,'".$userSellerID."'),IF('".$userEmail."'='',NULL,'".$userEmail."'),'".$userTax."','".$userTaxID."','".$userBuyercomm."','".$userSellercomm."','UNPAID','UNPAID','".$userNotes."','".$userSetup."','".$userDisposal."','".$userDisNotes."');");
      //if (!$d) array_push ($errs, "Couldn't insert data into database1. Please try again." .mysqli_error($connection));
      //else array_push($cons, "Successfully added user ".$userLastName.", ".$userFirstName."!");
      //}if(mysqli_num_rows($q1) == 0) {
	  //$d1 = mysqli_query($connection, "INSERT INTO masterusers (first_name, last_name, birth, street, city, state, zip, id, phone, email, tax, taxid, buyer_commission, seller_commission, notes, disposal, disposal_note) VALUES ('".$userFirstName."','".$userLastName."', '".$userBirth."', //'".$userStreet."','".$userCity."','".$userState."','".$userZip."','".$userID."','".$userPhone."',IF('".$userEmail."'='',NULL,'".$userEmail."'),'".$userTax."','".$userTaxID."','".$userBuyercomm."','".$userSellercomm."','".$userNotes."','".$userDisposal."','".$userDisNotes."');");
      //if (!$d1) array_push ($errs, "Couldn't insert data into database1. Please try again.");
      //else array_push($cons, "Successfully added user ".$userLastName.", ".$userFirstName."! into master database");
      } else {
	  $d = mysqli_query($connection, "UPDATE $Adb SET first_name='".$userFirstName."', last_name='".$userLastName."', buyer_id=IF('".$userBuyerID."'='',NULL,'".$userBuyerID."'), seller_id=IF
              ('".$userSellerID."'='',NULL,'".$userSellerID."'), email=IF('".$userEmail."'='',NULL,'".$userEmail."'), street='".$userStreet."', city='".$userCity."', state='".$userState."', zip='".$userZip."', id='".$userID."', phone='".$userPhone."', birth='".$userBirth."', tax='".$userTax."', taxid='".$userTaxID."', buyer_commission='".$userBuyercomm."', seller_commission='".$userSellercomm."', notes='".$userNotes."', setup='".$userSetup."', disposal='".$userDisposal."', disposal_note='".$userDisNotes."' WHERE usernum='".$userNum."'");
       if (!$d) array_push ($errs, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      else array_push($cons, "Successfully updated user ".$userLastName.", ".$userFirstName."!");
      //$d1 = mysqli_query($connection, "UPDATE masterusers SET
      //        email=IF('".$userEmail."'='',NULL,'".$userEmail."'), street='".$userStreet."', city='".$userCity."', state='".$userState."', zip='".$userZip."', id='".$userID."', phone='".$userPhone."', birth='".$userBirth."', tax='".$userTax."', taxid='".$userTaxID."', buyer_commission='".$userBuyercomm."', seller_commission='".$userSellercomm."', notes='".$userNotes."' WHERE first_name='".$userFirstName."' AND last_name='".$userLastName."' AND birth='".$userBirth."'");
      //if (!$d1) array_push ($errs, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      //else array_push($cons, "Successfully updated user ".$userLastName.", ".$userFirstName."!");

    }
  }
} else if ($action == "deluser") {
  $userFirstName = filter_input(INPUT_POST, "userFirstName", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userFirstName == false || $userFirstName == NULL) array_push($errs, "A first name is required.");

  $userLastName = filter_input(INPUT_POST, "userLastName", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userLastName == false || $userLastName == NULL) array_push($errs, "A last name is required.");

  $userBirth = filter_input(INPUT_POST, "userBirth", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($userBirth == false || $userBirth == NULL) array_push($errs, "A Birth Date is required.");

  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE first_name='".$userFirstName."' AND last_name='".$userLastName."' And birth='".$userBirth."'");
  if ($q != NULL && $result = mysqli_fetch_assoc($q)) {
    mysqli_query($connection, "UPDATE $Adbi SET buyer_id='' WHERE buyer_id='".$result["buyer_id"]."';");
    mysqli_query($connection, "UPDATE $Adbi SET seller_id='' WHERE seller_id='".$result["seller_id"]."';");
    mysqli_query($connection, "DELETE FROM $Adb WHERE first_name='".$userFirstName."' AND last_name='".$userLastName."' And birth='".$userBirth."';");
    array_push($cons, "Successfully deleted user ".$userFirstName." ".$userLastName."!");
  } else {
    array_push($errs, "This user couldn't be deleted because it wasn't found in the database.");
  }
} else if ($action == "dellot") {
  $lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotNumber == false || $lotNumber == NULL) array_push($errs2, "A lot number is required.");

  $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE lot_no='".$lotNumber."'");
  if ($q != NULL && $result = mysqli_fetch_assoc($q)) {
    mysqli_query($connection, "DELETE FROM $Adbi WHERE lot_no='".$lotNumber."';");
    array_push($cons2, "Successfully deleted lot ".$lotNumber."!");
  } else {
    array_push($errs2, "This lot couldn't be deleted because it wasn't found in the database.");
  }
}

?>
<!DOCTYPE html>
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
	<div id="userInfo" <?php if ($action == user) echo "style=\"display: block;\""; ?>>
      <p><b>This form is to only edit a customers name for the current auction.</b><br><b style="color: red;">This will not update them in the master database.</b><br><b>Please use the form under the Edit Users and Lots Tab to edit users in the master database.</b></p>
      <form action="editcustomer.php?action=user" method="POST">
        <table>
          <tr>
            <td><label for="userFirstName">First Name:</label></td>
            <td><input type="text" id="userFirstName" name="userFirstName" required/><br/></td>
            <td><label for="userLastName">Last Name:</label></td>
            <td><input type="text" id="userLastName" name="userLastName" required/><br/></td>
            <td><label for="userBirth">Date Of Birth:</label></td>
            <td><input type="text" id="userBirth" name="userBirth"/><br/></td>
          </tr>
          <tr>
            <td><label for="userStreet">Street Address:</label></td>
            <td><input type="text" id="userStreet" name="userStreet" required/><br/></td>
            <td><label for="userCity">City:</label></td>
            <td><input type="text" id="userCity" name="userCity" required/><br/></td>
            <td><label for="userState">State:</label></td>
            <td><input type="text" id="userState" name="userState" required/><br/></td>
          </tr>
          <tr>
		  <td><label for="userZip">Zip:</label></td>
            <td><input type="text" id="userZip" name="userZip" required/><br/></td>
            <td><label for="userID">ID #:</label></td>
            <td><input type="text" id="userID" name="userID"/><br/></td>
          <tr>
		  </tr>
            <td><label for="userBuyerID">Buyer ID:</label></td>
            <td><input type="text" id="userBuyerID" name="userBuyerID"/><br/></td>
            <td><label for="userSellerID">Seller ID:</label></td>
            <td><input type="text" id="userSellerID" name="userSellerID"/><br/></td>
          </tr>
          <tr>
			<td><label for="userPhone">Phone Number:</label></td>
            <td><input type="text" id="userPhone" name="userPhone" required/><br/></td>
            <td><label for="userEmail">E-mail:</label></td>
            <td><input type="text" id="userEmail" name="userEmail"/><br/></td>
          </tr>
          <tr>
		  <td><label for="userTax">Tax Rate:</label></td>
            <td><input type="text" value=6.875 id="userTax" name="userTax" required/><br/></td>
            <td><label for="userTaxID">Tax ID #:</label></td>
            <td><input type="text" id="userTaxID" name="userTaxID"/><br/></td>
           </tr>
           <tr>
            <td><label for="userBuyercomm">Buyer Commission:</label></td>
            <td><input type="text" id="userBuyercomm" name="userBuyercomm"/><br/></td>
            <td><label for="userSellercomm">Seller Commission:</label></td>
            <td><input type="text" id="userSellercomm" name="userSellercomm"/><br/></td>
            </td>
          </tr>
          <tr>
            <td><label for="userNotes">Customer Notes:</label></td>
            <td><input type="text" id="userNotes" name="userNotes" size="30"</td>
          </tr>
          <tr>
            <td colspan="1" style="text-align: right;">
            <input type="submit" value="Add/Edit User"/><br/>
            <td><input style="color: red;" type='reset' value='Reset All Fields' name='reset' onclick="return resetForm(this.form);"></td>
            <td><label for="userNum"> # To Update</label></td>
            <td><input size="4" id="userNum" name="userNum" readonly/><br/></td>
          </tr>
        </table>
      </form>
	<p>The list below is customers from current auction.</p>
      <p>Click a customer from below to edit for this auciton.</p>
      <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names..">
      <ul id="myUL">
<?php

//var firstName, lastName, userBuyerID, userSellerID, email;
        $userQuery = mysqli_query($connection, "SELECT * from $Adb ORDER BY last_name, first_name");
        while ($result = mysqli_fetch_array($userQuery)) {
		  $js .= "userLastName.value = '".$result["last_name"]."'; ";
		  $js .= "userFirstName.value = '".$result["first_name"]."'; ";
          $js .= "userBirth.value = '".$result["birth"]."'; ";
          $js .= "userStreet.value = '".$result["street"]."'; ";
          $js .= "userCity.value = '".$result["city"]."'; ";
          $js .= "userState.value = '".$result["state"]."'; ";
          $js .= "userZip.value = '".$result["zip"]."'; ";
          $js .= "userID.value = '".$result["id"]."'; ";
          $js .= "userPhone.value = '".$result["phone"]."'; ";
          $js .= "userEmail.value = '".$result["email"]."'; ";
          $js .= "userTax.value = '".$result["tax"]."'; ";
          $js .= "userTaxID.value = '".$result["taxid"]."'; ";
          $js .= "userBuyercomm.value = '".$result["buyer_commission"]."'; ";
          $js .= "userSellercomm.value = '".$result["seller_commission"]."'; ";
          $js .= "userNotes.value = '".$result["notes"]."'; ";
         // $js .= "userSetup.value = '".$result["setup"]."'; ";
          $js .= "userBuyerID.value = '".$result["buyer_id"]."'; ";
          $js .= "userSellerID.value = '".$result["seller_id"]."'; ";
          $js .= "userNum.value = '".$result["usernum"]."'; ";
          echo "        ";
          echo "<li><a href=\"#RegisterCurrent\" onclick=\"" . $js . ";\">";
          echo $result["last_name"];
          echo "<span>, </span>";
          echo $result["first_name"];
          echo "<span>, </span>";
          echo "<span>  </span>";
          echo $result["birth"];
          echo "<span>, </span>";
          echo "<span>  </span>";
          echo $result["city"];
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo $result["state"];
          echo "<span>  </span>";
          echo "<span>  </span>";
          echo $result["zip"];
          echo "<span>  </span>";
          echo "<span>  Seller ID:</span>";
          echo $result["seller_id"];
          echo "<span>  </span>";
          echo "<span>  Buyer ID:</span>";
          echo $result["buyer_id"];
          echo "<span class=\"links\">";
          echo "</span>";
          echo "</a></li>";

        }
        //echo "\n";
?>

	 </ul>
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
