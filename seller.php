<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

$sellerUser = filter_input(INPUT_GET, "sellerReportID", FILTER_SANITIZE_SPECIAL_CHARS);

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Seller Report</title>
    <link rel="stylesheet" type="text/css" href="./report.css"/>
  </head>
  <body style="font-size: 12pt;">
    <?php if (!$buyerUser) { ?>
    <p>Seller Reports:</p>
    <p>Users with no Seller ID are skipped, as are sellers with no items listed.</p>
    <p>
      This page contains formatting such that when printed there is a page
      break after this page and between every report.
    </p>
    <p>This report was generated at <?php echo date("c"); ?></p>
    <hr/>
    <?php
    }
    if ($sellerUser) $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id = '".$sellerUser."';");
    else $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id IS NOT NULL;");
    //$i = 0;
    //$ct = mysql_num_rows($q);
    while ($result = mysqli_fetch_assoc($q)) {
      if ($result["seller_id"] == "") continue;
      $total = 0;
      $divide = 100;
      $totalcomm = 0;
      $totalsetup = 0;
      $totalsale = 0;
      $q2 = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id='".$result["seller_id"]."';");
      if (mysqli_num_rows($q2) == 0) continue;
      echo "	<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>\n";
      echo "	<script src='http://spez.tv/auction/src/jquery.table2excel.js'></script>\n";
      echo "	<table class='table2excel' data-tableName=''>\n";
      echo "	<img src='allamerican.png'/>";
      echo "    <td>Seller Report for (Seller ID ".$result["seller_id"].")\n";
      echo "	<tr>\n";
      echo "	<td> ".$result["first_name"]." ".$result["last_name"]." </p>\n";
      echo "	<tr>\n";
      echo "	<td> ".$result["street"]." ".$result["city"]." ".$result["state"]." ".$result["zip"]."</p>\n";
      echo "	<tr>\n";
      echo "	<td> ".$result["phone"]." ".$result["email"]."</p>\n";
      echo "      <tr>\n";
      echo "        <td>Lot Number<td/>\n";
      echo "        <td>Lot Title<td/>\n";
      echo "        <td>Commission<td/>\n";
      echo "        <td>QTY<td/>\n";
      echo "        <td class=\"right\">Sale Price<td/>\n";
      echo "      </tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"10\">---------------------------------------------------------------------------------------------------------<td/>\n";
      echo "      </tr>\n";
      while ($r2 = mysqli_fetch_assoc($q2)) {
        echo "      <tr>\n";
        echo "        <td>".$r2["lot_no"]."<td/>\n";
        echo "        <td>".substr($r2["title"], 0, 50)."<td/>\n";
        echo "        <td>".(($result["seller_commission"] && $result["seller_commission"] != 0) ? "%".$result["seller_commission"] : "NO COMMISSION")."<td/>\n";
        if ($result["seller_commission"] && $result["seller_commission"] != 0) $totalcomm += round($r2["price"] * $r2["qty"] * $result["seller_commission"] / $divide, 2);
        echo "        <td>".$r2["qty"]."<td/>\n";
        echo "        <td class=\"right\">".(($r2["price"] && $r2["price"] != 0) ? "$".round($r2["price"], 2) : "NO SALE")."<td/>\n";
        if ($r2["price"] && $r2["price"] != 0) $total += round($r2["price"] * $r2["qty"], 2);
        if ($r2["price"] && $result["seller_commission"] != 0) $totalsale += round($r2["price"] * $r2["qty"], 2) - round($r2["price"] * $r2["qty"] * $result["seller_commission"] / $divide, 2);
        $totalsetup = $result["setup"];
        $totaldisposal = $result["disposal"];
        $disposalnotes = $result["disposal_note"];
        echo "      </tr>\n";
      }
      echo "      <tr>\n";
      echo "        <td colspan=\"10\">---------------------------------------------------------------------------------------------------------<td/>\n";
      echo "      </tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Sales:<td/>\n";
      if ($total == 0) $t = "NONE";
      else $t = "$".$total;
      echo "        <td class=\"right\">".$t."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Total Commission:<td/>\n";
      if ($totalcomm == 0) $tc = "NONE";
      else $tc = "$".$totalcomm;
      echo "        <td class=\"right\">".$tc."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Setup Fee:<td/>\n";
      if ($totalsetup == 0) $ts = "NONE";
      else $ts = "$".$totalsetup;
      echo "        <td class=\"right\">".$ts."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Disposal Fee:<td/>\n";
      if ($totaldisposal == 0) $td = "NONE";
      else $td = "$".$totaldisposal;
      echo "        <td class=\"right\">".$td."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"2\">Disposal Notes:<td/>\n";
      echo "        <td class=\"right\">".$result["disposal_note"]."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Total Payout Owed To Seller:<td/>\n";
      if ($total == 0) $tv = "NONE";
      else $tv = "$".($total - $totalcomm - $totalsetup - $totaldisposal);
      echo "        <td class=\"right\">".$tv."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Payment Status:<td/>\n";
      echo "        <td class=\"right\">".$result["seller_paid"]."<td/>\n";
      echo "      </tr>\n";
      echo "        <td colspan=\"3\">Check Number:<td/>\n";
      echo "        <td class=\"right\">".$result["seller_check"]."<td/>\n";
      echo "      </tr>\n";
      echo "    </table>\n";
//
      echo "    <hr/>\n";
      echo " <p>This receipt shows sold items and reserve items only.</p>";
      echo " <p>Any items not on the list did not sell.</p>";
    }
    ?>
  <button>Export</button>
  <script>
			$("button").click(function() {
				$(".table2excel").table2excel({
					// eclude CSS class
					exclude:".noExl",
					name: "Auction Results",
					filename: "Buyer Report",
					fileext: ".xls",
				});
			});
		</script>
  </body>
</html>
<?php
mysqli_close($connection);
?>
