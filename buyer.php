<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$buyerUser = filter_input(INPUT_GET, "buyerReportID", FILTER_SANITIZE_SPECIAL_CHARS);


?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Buyer Report</title>
    <link rel="stylesheet" type="text/css" href="./report.css"/>
  </head>
  <body>
    <?php if (!$buyerUser) { ?>
    <p>Buyer Reports:</p>
    <p>Users with no Buyer ID are skipped, as are buyers with no purchased items.</p>
    <p>
      This page contains formatting such that when printed there is a page
      break after this page and between every report.
    </p>
    <p>This report was generated at <?php echo date("c"); ?></p>
    <hr/>
    <?php
    }
    if ($buyerUser) $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id = '".$buyerUser."';");
    else $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id IS NOT NULL;");
    //$i = 0;
    //$ct = mysql_num_rows($q);
    while ($result = mysqli_fetch_assoc($q)) {
      if ($result["buyer_id"] == "") continue;
      $total = 0;
      $totaltax = 0;
      $totalcomm = 0;
      $totalsale = 0;
      $divide = 100.00;
      
      
      $q2 = mysqli_query($connection, "SELECT * FROM $Adbi WHERE buyer_id='".$result["buyer_id"]."';");
      if (mysqli_num_rows($q2) == 0) continue;
      echo "	<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>\n";
      echo "	<script src='http://spez.tv/auction/src/jquery.table2excel.js'></script>\n";
      echo "	<table class='table2excel' data-tableName='$buyerUser'>\n";
      echo "	<img src='allamerican.png'/>";
      echo "    <td>Buyer Report for (Buyer ID ".$result["buyer_id"].")</p>\n";
      echo "	<tr>\n";
      echo "	<td> ".$result["first_name"]." ".$result["last_name"]." </p>\n";
      echo "	<tr>\n";
      echo "	<td> ".$result["street"]." ".$result["city"]." ".$result["state"]." ".$result["zip"]."</p>\n";
      echo "	<tr>\n";
      echo "	<td> ".$result["phone"]." ".$result["email"]."</p>\n";
      echo "      <tr>\n";
      echo "        <td>Lot<br>Number</p>\n";
      echo "        <td>Title</p>\n";
      //echo "        <td>&nbsp&nbspTable<br>Or Bundle&nbsp\n</p>";
      echo "        <td>Price&nbsp&nbsp</p>\n";
      echo "        <td>QTY</p>\n";
      echo "        <td>Tax</p>\n";
      echo "        <td class=\"right\">Commission</p>\n";
      echo "      </tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"25\">------------------------------------------------------------------------------------------<td/>\n";
      echo "      </tr>\n";
      while ($r2 = mysqli_fetch_assoc($q2)) {
        echo "      <tr>\n";
        echo "        <td>".$r2["lot_no"]."<p/>\n";
        echo "        <td>".$r2["title"]."&nbsp&nbsp</p>\n";
        //echo "        <td>&nbsp".$r2["bundle"]."</p>\n";
        echo "        <td>".(($r2["price"] && $r2["price"] != 0) ? "$".round($r2["price"], 2) : "NO SALE")."</p>\n";
        if ($r2["price"] && $r2["price"] != 0) $total += round($r2["price"] * $r2["qty"], 2);
        echo "        <td>&nbsp&nbsp".$r2["qty"]."</p>\n";
        echo "        <td>".(($result["tax"] && $result["tax"] != 0) ? "%" .$result["tax"] : "NO Tax")."</p>\n";
        if ($r2["price"] && $result["tax"] != 0) $totaltax += round($r2["price"] * $r2["qty"] * $result["tax"] / $divide, 2);
        echo "        <td class=\"right\">".(($result["buyer_commission"] && $result["buyer_commission"] != 0) ? "%" .$result["buyer_commission"] : "NO COMIISSION")."</p>\n";
        if ($r2["price"] && $result["buyer_commission"] != 0) $totalcomm += round($r2["price"] * $r2["qty"] * $result["buyer_commission"] / $divide, 2);
        //echo "        <td class=\"right\">".(($r2["buyer_commission"] && $r2["price"] && $r2["tax"] != 0) ? "$" .$r2["buyer_commission"] : "NO SALE")."</p>\n";
        if ($r2["price"] && $r2["price"] != 0) $totalsale += round($r2["price"] * $r2["qty"] * $result["buyer_commission"] / $divide, 2, PHP_ROUND_HALF_UP) + round($r2["qty"] * $r2["price"] * $result["tax"] / $divide, 2) + round($r2["price"] * $r2["qty"], 2, PHP_ROUND_HALF_UP);
        echo "      </tr>\n";
      }
      echo "      <tr>\n";
      echo "        <td colspan=\"25\">------------------------------------------------------------------------------------------<td/>\n";
      echo "      </tr>\n";
      echo "      </tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Of Items:<td/>\n";
      if ($total == 0) $t = "NONE";
      else $t = "$".$total;
      echo "        <td class=\"right\">".$t."<td/>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Tax Due:<td/>\n";
      if ($totaltax == 0) $tt = "NONE";
      else $tt = "$".$totaltax;
      echo "        <td class=\"right\">".$tt."<td/>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Commission Due:<td/>\n";
      if ($totalcomm == 0) $tc = "NONE";
      else $tc = "$".$totalcomm;
      echo "        <td class=\"right\">".$tc."<td/>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Payment Due:<td/>\n";
      if ($total + $totaltax + $totalcomm == 0) $tv = "NONE";
      else $tv = "$" .($total + $totaltax + $totalcomm);
      echo "        <td class=\"right\">".$tv."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Invoice Status:<td/>\n";
      echo "        <td class=\"right\">".$result["paid"]."<td/>\n";
      echo "      </tr>\n";
      echo "    </table>\n";
      //echo "    <p>Buyer Report #".$i++." of ".$ct."</p>";
      echo "    <hr/>\n";
    }
    ?>
   
  <form style="display: inline;" action="paid.php" method="GET">
          <input type="hidden" name="lotBuyerID" value="<?php echo $buyerUser; ?>"/>
          <div colspan="2" style="display: inline;">
		  <input type="Submit" value="Mark as Paid" class="no-print"/><br/>
        </form>
</html>
<?php
mysqli_close($connection);
?>
