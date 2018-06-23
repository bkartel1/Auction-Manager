<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);

$errs2 = array();
$cons2 = array();
$errs3 = array();
$cons3 = array();
$errs4 = array();
$cons4 = array();
$errs5 = array();
$cons5 = array();
$errs6 = array();
$cons6 = array();
$null = NULL;
$action = filter_input(INPUT_GET, "action");

if ($action == "lot") { //add/edit lot
  $lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");

  $lotSellerID = filter_input(INPUT_POST, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotSellerID == false || $lotNumber == NULL) array_push($errs, "A lot must have a seller ID.");
  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$lotSellerID."';");
  mysqli_num_rows($q);
  if(mysqli_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");

  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");

  //$lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);


  }

  $lotPrice = filter_input(INPUT_POST, "lotPrice", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotTitle = filter_input(INPUT_POST, "lotTitle");

  $lotQty = filter_input(INPUT_POST, "lotQty", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotReserve = filter_input(INPUT_POST, "lotReserve", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotAbsentee = filter_input(INPUT_POST, "lotAbsentee", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotAbsenteeBid = filter_input(INPUT_POST, "lotAbsenteeBid", FILTER_SANITIZE_SPECIAL_CHARS);
  
  $itemNum = filter_input(INPUT_POST, "itemNum", FILTER_SANITIZE_SPECIAL_CHARS);

  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE lot_no='".$lotNumber."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi (lot_no, buyer_id, seller_id, price, title, paid, seller_paid, qty, reserve, absentee, absentee_bidder) ".
              "VALUES ('".$lotNumber."',IF('".$lotBuyerID."'='',NULL,'".$lotBuyerID."'),IF('".$lotSellerID."'='',NULL,'".$lotSellerID."'),IF('".$lotPrice."'='',0,'".$lotPrice."'),'".$lotTitle."','UNPAID','UNPAID',IF('".$lotQty."'='',NULL,'".$lotQty."'),IF('".$lotReserve."'='',NULL,'".$lotReserve."'),IF('".$lotAbsentee."'='',NULL,'".$lotAbsentee."'),IF('".$lotAbsenteeBid."'='',NULL,'".$lotAbsenteeBid."'));");
      if (!$d) array_push ($errs3, mysqli_error ()."Couldn't insert data into database. Please try again." .mysqli_error($connection));
      else array_push($cons3, "Successfully added lot number ".$lotNumber."!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET buyer_id=IF('".$lotBuyerID."'='',NULL,'".$lotBuyerID."'), seller_id=IF
              ('".$lotSellerID."'='',NULL,'".$lotSellerID."'), price=IF('".$lotPrice."'='',0,'".$lotPrice."'), title='".$lotTitle."', paid='UNPAID', seller_paid='UNPAID', qty=IF('".$lotQty."'='',NULL,'".$lotQty."'), reserve=IF('".$lotReserve."'='',NULL,'".$lotReserve."'), absentee=IF('".$lotAbsentee."'='',NULL,'".$lotAbsentee."'), absentee_bidder=IF('".$lotAbsenteeBid."'='',NULL,'".$lotAbsenteeBid."') WHERE itemnum='".$itemNum."'");
      $d2 = mysqli_query($connection, "UPDATE $Adb SET paid='UNPAID' WHERE buyer_id='".$lotBuyerID."'");
      if (!$d) array_push ($errs3, "Couldn't update data in database. Please try again." .mysqli_error($connection));
      else array_push($cons3, "Successfully updated lot number ".$lotNumber."!");
    }
  }
}/*else if ($action == "bundle") { //add/edit lot
  $lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");

  $lotNumber1 = filter_input(INPUT_POST, "lotNumber1", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber2 = filter_input(INPUT_POST, "lotNumber2", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber3 = filter_input(INPUT_POST, "lotNumber3", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber4 = filter_input(INPUT_POST, "lotNumber4", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber5 = filter_input(INPUT_POST, "lotNumber5", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber6 = filter_input(INPUT_POST, "lotNumber6", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber7 = filter_input(INPUT_POST, "lotNumber7", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber8 = filter_input(INPUT_POST, "lotNumber8", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotNumber9 = filter_input(INPUT_POST, "lotNumber9", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotSellerID = filter_input(INPUT_POST, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotSellerID == false || $lotNumber == NULL) array_push($errs, "A lot must have a seller ID.");
  //$q = mysql_query("SELECT * FROM users WHERE seller_id='".$lotSellerID."';");
  //mysql_num_rows($q);
  //if(mysql_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");

  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");

  //$lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);


  }

  $lotPrice = filter_input(INPUT_POST, "lotPrice", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotTitle = filter_input(INPUT_POST, "lotTitle");

  $lotQty = filter_input(INPUT_POST, "lotQty", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotReserve = filter_input(INPUT_POST, "lotReserve", FILTER_SANITIZE_SPECIAL_CHARS);

  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE lot_no='".$lotNumber."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi ( bundle)
              VALUES ('Bundled');");
      if (!$d) array_push ($errs2, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons2, "Successfully Bundled lot number ".$lotNumber."!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber."'");
      $d1 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber1."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber2."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber3."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber4."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber5."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber6."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber7."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber8."'");
      $d2 = mysqli_query($connection, "UPDATE $Adbi SET bundle='BUNDLED', price='".$lotPrice."', buyer_id='".$lotBuyerID."' WHERE lot_no='".$lotNumber9."'");
      if (!$d) array_push ($errs4, "Couldn't update data in database. Please try again.");
      else array_push($cons4, "Successfully Bundled lots!");
    }
  }
}else if ($action == "table") { //add/edit lot
  //$lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");

  $lotSellerID = filter_input(INPUT_POST, "lotSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotSellerID == false) array_push($errs, "A lot must have a seller ID.");
  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$lotSellerID."';");
  mysqli_num_rows($q);
  if(mysqli_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");

  $lotBuyerID = filter_input(INPUT_POST, "lotBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");



  //$lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);


  }

  $lotPrice = filter_input(INPUT_POST, "lotPrice", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotTitle = filter_input(INPUT_POST, "lotTitle");

  $lotQty = filter_input(INPUT_POST, "lotQty", FILTER_SANITIZE_SPECIAL_CHARS);

  $qt = mysqli_query($connection, "SELECT * FROM items WHERE seller_id='".$lotSellerID."' AND price=0.00;");
  $totalPrice = $lotPrice / mysqli_num_rows($qt);

  $lotReserve = filter_input(INPUT_POST, "lotReserve", FILTER_SANITIZE_SPECIAL_CHARS);

  if (count($errs) == 0) {
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id='".$lotSellerID."';");
    if(mysqli_num_rows($q) == 0) {
      $d = mysqli_query($connection, "INSERT INTO $Adbi ( bundle)
              VALUES ('Bundled');");
      if (!$d) array_push ($errs5, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons5, "Successfully added lot number ".$lotNumber."!");
    } else {
      $d = mysqli_query($connection, "UPDATE $Adbi SET buyer_id='".$lotBuyerID."',
               price='".$totalPrice."', bundle='Table Buy' WHERE seller_id='".$lotSellerID."' AND price=0.00");
      $d2 = mysqli_query($connection, "UPDATE users SET paid='UNPAID' WHERE buyer_id='".$lotBuyerID."'");
      if (!$d) array_push ($errs5, "Couldn't update data in database. Please try again.");
      else array_push($cons4, "Successfully sold remainder of items on seller '".$lotSellerID."'s Table!");
    }
  }
}else if ($action == "dellot") {
  $itemNumber = filter_input(INPUT_POST, "itemNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($itemNumber == false || $itemNumber == NULL) array_push($errs2, "A number is required.");

  $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE itemnum='".$itemNumber."'");
  if ($q != NULL && $result = mysqli_fetch_assoc($q)) {
    mysqli_query($connection, "DELETE FROM $Adbi WHERE itemnum='".$itemNumber."';");
    array_push($cons3, "Successfully deleted inventory # ".$itemNumber."!");
  } else {
    array_push($errs3, "This item couldn't be deleted because it wasn't found in the database.");
  }
}else if ($action == "box") { //add/edit lot

  //$lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");

  $lotSellerID = filter_input(INPUT_POST, "lotboxSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotSellerID == false) array_push($errs, "A lot must have a seller ID.");
  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$lotSellerID."';");
  mysqli_num_rows($q);
  if(mysqli_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");

  $lotBuyerID = filter_input(INPUT_POST, "lotboxBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");

  //$lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);


  }

  $lotPrice = filter_input(INPUT_POST, "lotboxPrice", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotTitle = filter_input(INPUT_POST, "lotboxTitle");

  $lotQty = filter_input(INPUT_POST, "lotboxQty", FILTER_SANITIZE_SPECIAL_CHARS);

  $boxlot = "BoxLot";

  //$lotReserve = filter_input(INPUT_POST, "lotReserve", FILTER_SANITIZE_SPECIAL_CHARS);

  if (count($errs) == 0) {
    //$q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE lot_no='".$lotNumber."';");
    //if(mysqli_num_rows($q) == 0) {
    {
      $d = mysqli_query($connection, "INSERT INTO $Adbi (lot_no, buyer_id, seller_id, price, title, paid, seller_paid, qty) ".
              "VALUES ('".$lotSellerID.$boxlot."',IF('".$lotBuyerID."'='',NULL,'".$lotBuyerID."'),IF('".$lotSellerID."'='',NULL,'".$lotSellerID."'),IF('".$lotPrice."'='',0,'".$lotPrice."'),'".$lotTitle."','UNPAID','UNPAID',IF('".$lotQty."'='',NULL,'".$lotQty."'));");
      if (!$d) array_push ($errs2, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons2, "Successfully added lot number ".$lotNumber."!");
    //} else {
      //$d = mysqli_query($connection, "UPDATE $Adbi SET buyer_id=IF('".$lotBuyerID."'='',NULL,'".$lotBuyerID."'), seller_id=IF
       //       ('".$lotSellerID."'='',NULL,'".$lotSellerID."'), price=IF('".$lotPrice."'='',0,'".$lotPrice."'), title='".$lotTitle."', paid='UNPAID', seller_paid='UNPAID', qty=IF('".$lotQty."'='',NULL,'".$lotQty."'), reserve=IF('".$lotReserve."'='',NULL,'".$lotReserve."') WHERE lot_no='".$lotNumber."'");
      //$d2 = mysqli_query($connection, "UPDATE $Adb SET paid='UNPAID' WHERE buyer_id='".$lotBuyerID."'");
      //if (!$d) array_push ($errs2, "Couldn't update data in database. Please try again.");
      //else array_push($cons2, "Successfully updated lot number ".$lotNumber."!");
    }
  }
}else if ($action == "notloaded") { //add/edit lot

  //$lotNumber = filter_input(INPUT_POST, "lotNumber", FILTER_SANITIZE_SPECIAL_CHARS);
  //if ($lotNumber == false || $lotNumber == NULL) array_push($errs, "A lot number is required.");

  $lotSellerID = filter_input(INPUT_POST, "lotgoSellerID", FILTER_SANITIZE_SPECIAL_CHARS);
  if ($lotSellerID == false) array_push($errs, "A lot must have a seller ID.");
  $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id='".$lotSellerID."';");
  mysqli_num_rows($q);
  if(mysqli_num_rows($q) == 0) array_push($errs, "Seller ID \"".$lotSellerID."\" does not map to a valid user.");

  $lotBuyerID = filter_input(INPUT_POST, "lotgoBuyerID", FILTER_SANITIZE_SPECIAL_CHARS);
  $qb = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id='".$lotBuyerID."';");
  if($lotBuyerID && mysqli_num_rows($qb) == 0) {
    array_push($errs, "Buyer ID \"".$lotBuyerID."\" does not map to a valid user.");

  //$lotPaid = filter_input(INPUT_POST, "lotPaid", FILTER_SANITIZE_SPECIAL_CHARS);


  }

  $lotPrice = filter_input(INPUT_POST, "lotgoPrice", FILTER_SANITIZE_SPECIAL_CHARS);

  $lotTitle = filter_input(INPUT_POST, "lotgoTitle");

  $lotQty = filter_input(INPUT_POST, "lotgoQty", FILTER_SANITIZE_SPECIAL_CHARS);

  //$lotReserve = filter_input(INPUT_POST, "lotReserve", FILTER_SANITIZE_SPECIAL_CHARS);

  if (count($errs) == 0) {
    //$q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE lot_no='".$lotNumber."';");
    //if(mysqli_num_rows($q) == 0) {
    {
      $d = mysqli_query($connection, "INSERT INTO $Adbi (lot_no, buyer_id, seller_id, price, title, paid, seller_paid, qty) ".
              "VALUES ('".$lotSellerID."',IF('".$lotBuyerID."'='',NULL,'".$lotBuyerID."'),IF('".$lotSellerID."'='',NULL,'".$lotSellerID."'),IF('".$lotPrice."'='',0,'".$lotPrice."'),'".$lotTitle."','UNPAID','UNPAID',IF('".$lotQty."'='',NULL,'".$lotQty."'));");
      if (!$d) array_push ($errs6, mysqli_error ()."Couldn't insert data into database. Please try again.");
      else array_push($cons6, "Successfully added lot number ".$lotNumber."!");
    //} else {
      //$d = mysqli_query($connection, "UPDATE $Adbi SET buyer_id=IF('".$lotBuyerID."'='',NULL,'".$lotBuyerID."'), seller_id=IF
       //       ('".$lotSellerID."'='',NULL,'".$lotSellerID."'), price=IF('".$lotPrice."'='',0,'".$lotPrice."'), title='".$lotTitle."', paid='UNPAID', seller_paid='UNPAID', qty=IF('".$lotQty."'='',NULL,'".$lotQty."'), reserve=IF('".$lotReserve."'='',NULL,'".$lotReserve."') WHERE lot_no='".$lotNumber."'");
      //$d2 = mysqli_query($connection, "UPDATE $Adb SET paid='UNPAID' WHERE buyer_id='".$lotBuyerID."'");
      //if (!$d) array_push ($errs2, "Couldn't update data in database. Please try again.");
      //else array_push($cons2, "Successfully updated lot number ".$lotNumber."!");
    }
  }
}
*/
?><!DOCTYPE html>
<?php
include "header.php";

if (count($errs3) > 0) {
      echo "<div id=\"err\">\n";
      while ($res = array_pop($errs3)) {
        echo "      <p>" . $res. "</p>\n";
      }
      echo "</div>";
    }

    if (count($cons3) > 0) {
      echo "<div id=\"confirm\">\n";
      while ($res = array_pop($cons3)) {
        echo "      <p>" . $res. "</p>\n";
      }
      echo "</div>";
    }

    echo "\n";
?>
      <p>Use the Edit or Delete buttons below to edit or delete and item. Once an item is deleted it can not be undone.</p>
      <form action="editlots.php?action=lot" method="POST">
        <table>
          <tr>
            <td><label for="lotNumber">Lot Number:</label></td>
            <td><input type="text" size="4" id="lotNumber" name="lotNumber"/><br/></td>
            <td><label for="lotSellerID">Seller ID:</label></td>
            <td><input type="text" size="4" id="lotSellerID" name="lotSellerID"required/><br/></td>
            <td><label for="lotTitle">Title:</label></td>
            <td><input type="text" id="lotTitle" name="lotTitle"/><br/></td>
            <td><label for="lotTitle">Reserve:</label></td>
            <td><input type="text" id="lotReserve" name="lotReserve"/><br/></td>
            <td><label for="lotAbsentee">Absentee:</label></td>
            <td><input type="text" size="8" id="lotAbsentee" name="lotAbsentee"/><br/></td>
            <td><label for="lotAbsenteeBid">Absentee Buyer ID:</label></td>
            <td><input type="text" size="4" id="lotAbsenteeBid" name="lotAbsenteeBid"/><br/></td>
            </tr>
			     <tr>
			      <td><label for="lotPrice">Sale Price:</label></td>
            <td><input type="text" id="lotPrice" min="0" size="4" name="lotPrice"/><br/></td>
            <td><label for="lotBuyerID">Buyer ID:</label></td>
            <td><input type="text" size="4" id="lotBuyerID" name="lotBuyerID"/><br/></td>
            <td><label for="lotQty">QTY:</label></td>
            <td><input type="text" value="1" size="4" id="lotQty" name="lotQty"/><br/></td>
            <td><label for="itemNum">Inventory # To Update</label></td>
            <td><input size="4" id="itemNum" name="itemNum" readonly/><br/></td>
          </tr>
          <tr>
            <td colspan="5" style="text-align: center;">
			<input type="submit" value="Add/Edit Lot"/><br/>
      <td><input style="color: red;" type='reset' value='Reset All Fields' name='reset' onclick="return resetForm(this.form);"></td>
            </tr>
            </td>
          </tr>
        </table>
      </form>
      <p>Select a lot from below to edit or delete an existing entry.</p>
      <div id="ilist">
<?php
//var lotNumber, lotBuyerID, lotSellerID, lotPrice, lotTitle;
         $itemQuery = mysqli_query($connection, "SELECT * from $Adbi ORDER BY itemnum DESC");
        while ($result = mysqli_fetch_array($itemQuery)) {
          //$js = "lotNumber = document.getElementById(\"lotNumber\"); lotLoads[\"".$result["lot_no"]."\"] = function() {";
          $js = "itemNumber = document.getElementById(\"itemNumber\"); itemLoads[\"".$result["itemnum"]."\"] = function() {";
          $js .= "lotNumber.value = '".$result["lot_no"]."'; ";
          //$js .= "itemNumber.value = '".$result["itemnum"]."'; ";
          if ($result["buyer_id"]) $js .= "lotBuyerID.value = '".$result["buyer_id"]."'; ";
          else $js .= "lotBuyerID.value = ''; ";
          $js .= "lotSellerID.value = '".$result["seller_id"]."'; ";
          if ($result["price"]) $js .= "lotPrice.value = '".$result["price"]."'; ";
          else $js .= "lotPrice.value = ''; ";
          if ($result["title"]) $js .= "lotTitle.value = '".$result["title"]."'; ";
          else $js .= "lotTitle.value = ''; ";
          if ($result["qty"]) $js .= "lotQty.value = '".$result["qty"]."'; ";
          else $js .= "lotQty.value = ''; ";
          if ($result["reserve"]) $js .= "lotReserve.value = '".$result["reserve"]."'; ";
          else $js .= "lotReserve.value = ''; ";
          if ($result["absentee"]) $js .= "lotAbsentee.value = '".$result["absentee"]."'; ";
          else $js .= "lotAbsentee.value = ''; ";
          if ($result["absentee_bidder"]) $js .= "lotAbsenteeBid.value = '".$result["absentee_bidder"]."'; ";
          else $js .= "lotAbsenteeBid.value = ''; ";
          if ($result["itemnum"]) $js .= "itemNum.value = '".$result["itemnum"]."'; ";
          else $js .= "itemNum.value = ''; ";
          //if ($result["paid"]) $js .= "lotPaid.value = '".$result["paid"]."'; ";
          //else $js .= "lotPaid.value = ''; ";
          $js .= "};";
          echo "        ";
          echo "<script type=\"text/javascript\">".$js."</script>\n";
          echo "        ";
          echo "<div>";
          echo "<span> Inventory # </span>";
          echo $result["itemnum"];
          echo "<span>,    </span>";
          echo "<span> Lot # </span>";
          echo $result["lot_no"];
          echo "<span>,    </span>";
          echo $result["title"];
          echo "<span>, sold by </span>";
          echo $result["seller_id"];
          echo "<span>,  bought by </span>";
          echo $result["buyer_id"];
          echo "<span>,   </span>";
          echo "<span>    </span>";
          echo "<span>    </span>";
          echo "<span> QTY   </span>";
          echo $result["qty"];
          echo "<span>,    </span>";
          echo "<span>    </span>";
          echo "<span> Price   </span>";
          echo $result["price"];
          echo "<span class=\"links\">";
          $js2 = "itemLoads['".$result["itemnum"]."']();";
          echo "<a href=\"#lotButton\" onclick=\"" . $js2 . ";\">Edit</a> - ";
          echo "<a href=\"deleteLot.php?no=".$result["itemnum"]."\">Delete</a>";
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
