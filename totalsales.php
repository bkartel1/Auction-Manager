<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

//$buyerUser = filter_input(INPUT_GET, "buyerReportID", FILTER_SANITIZE_SPECIAL_CHARS);


?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Buyer Report</title>
    <link rel="stylesheet" type="text/css" href="./report.css"/>
  </head>
  <body>
    <?php  { ?>
    <p>This report was generated at <?php echo date("c"); ?></p>
    <hr/>
    <?php
    }
    //if ($buyerUser) $q = mysql_query("SELECT * FROM users WHERE buyer_id = '".$buyerUser."';");
     //$q = mysql_query("SELECT * FROM users WHERE buyer_id IS NOT NULL;");
    //$i = 0;
    //$ct = mysql_num_rows($q);
    //while ($result = mysql_fetch_assoc($q)) {
      //if ($result["buyer_id"] == "") continue;
      //$total = 0;
      //$totaltax = 0;
      //$totalcomm = 0;
      //$totalsale = 0;
      //$divide = 100.00;
  
      //$q = mysql_query("SELECT * FROM users WHERE buyer_id IS NOT NULL;");
      //if ($result["buyer_id"] == "") continue;
      $total = 0;
      $totaltax = 0;
      $totalcomm = 0;
      $totalsellcomm = 0;
      $totalsale = 0;
      $divide = 100.00;
      $q2 = mysqli_query($connection, "SELECT * FROM $Adbi WHERE paid='PAID';");
      //if (mysql_num_rows($q2) == 0) continue;
      $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id ;");
      echo "	<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>\n";
      echo "	<script src='http://spez.tv/auction/src/jquery.table2excel.js'></script>\n";
      echo "	<table class='table2excel' data-tableName='allitem'>\n";
      echo "	<img src='allamerican.png'/>";
      //echo "    <td>Buyer Report for (Buyer ID ".$result["buyer_id"].")</p>\n";
      //echo "	<tr>\n";
      //echo "	<td> ".$result["first_name"]." ".$result["last_name"]." </p>\n";
      //echo "	<tr>\n";
      //echo "	<td> ".$result["street"]." ".$result["city"]." ".$result["state"]." ".$result["zip"]."</p>\n";
      //echo "	<tr>\n";
      //echo "	<td> ".$result["phone"]." ".$result["email"]."</p>\n";
      echo "      <tr>\n";
      echo "        <td>Lot Number</p>\n";
      echo "        <td>Title</p>\n";
      echo "        <td>Price</p>\n";
      echo "        <td>QTY&nbsp</p>\n";
      echo "		<td>&nbsp&nbspItem<br>Sale Type</td>";
      echo "        <td>Tax&nbsp&nbsp&nbsp</p>\n";
      echo "        <td>Seller Comm</p>\n";
      echo "        <td class=\"right\">Buyer Comm</p>\n";
      echo "      </tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"20\">-----------------------------------------------------------------------------------------------------<td/>\n";
      echo "      </tr>\n";
      while ($result = mysqli_fetch_assoc($q)){ 
      while ($r2 = mysqli_fetch_assoc($q2)) {
        echo "      <tr>\n";
        echo "        <td>".$r2["lot_no"]."<p/>\n";
        echo "        <td>".$r2["title"]."</p>\n";
        echo "        <td>".(($r2["price"] && $r2["price"] != 0) ? "$".$r2["price"] : "NO SALE")."</p>\n";
        if ($r2["price"] && $r2["price"] != 0) $total += $r2["price"];
        echo "        <td>".$r2["qty"]."</p>\n";
        echo "        <td>".$r2["bundle"]."</p>\n";
        echo "        <td>".(($result["tax"] && $result["tax"] != 0) ? "%" .$result["tax"] : "NO Tax")."</p>\n";
        if ($r2["price"] && $result["tax"] != 0) $totaltax += round($r2["price"] * $result["tax"]) / $divide;
        echo "        <td class=\"right\">".(($result["buyer_commission"] && $result["buyer_commission"] != 0) ? "%" .$result["buyer_commission"] : "NO COMMISSION")."</p>\n";
        if ($result["buyer_commission"] && $result["buyer_commission"] != 0) $totalcomm += round($r2["price"] * $result["buyer_commission"]) / $divide;
        echo "        <td class=\"right\">".(($result["seller_commission"] && $result["seller_commission"] != 0) ? "%" .$result["seller_commission"] : "NO COMMISSION")."</p>\n";
        if ($r2["price"] && $result["seller_commission"] != 0) $totalsellcomm += round($r2["price"] * $result["seller_commission"]) / $divide;
        //echo "        <td class=\"right\">".(($r2["buyer_commission"] && $r2["price"] && $r2["tax"] != 0) ? "$" .$r2["buyer_commission"] : "NO SALE")."</p>\n";
        if ($r2["price"] && $r2["price"] != 0) $totalsale += round($r2["price"] * $r2["qty"] * $result["buyer_commission"] / $divide, 2) + round($r2["qty"] * $r2["price"] * $result["tax"] / $divide, 2) + round($r2["price"] * $r2["qty"], 2);
        echo "      </tr>\n";
      }

      
      //echo "    <p>Buyer Report #".$i++." of ".$ct."</p>";
      //echo "    <hr/>\n";
 
    }
      echo "      <tr>\n";
      echo "        <td colspan=\"20\">------------------------------------------------------------------------------------------------------<td/>\n";
      echo "      </tr>\n";
      echo "      </tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Sales:<td/>\n";
      if ($total == 0) $t = "NONE";
      else $t = "$".$total;
      echo "        <td class=\"right\">".$t."<td/>\n";
      echo "      <tr>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Tax Collected:<td/>\n";
      if ($totaltax == 0) $tt = "NONE";
      else $tt = "$".$totaltax;
      echo "        <td class=\"right\">".$tt."<td/>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Buyers Commission Collected:<td/>\n";
      if ($totalcomm == 0) $tc = "NONE";
      else $tc = "$".$totalcomm;
      echo "        <td class=\"right\">".$tc."<td/>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Sellers Commission Collected:<td/>\n";
      if ($totalsellcomm == 0) $tsc = "NONE";
      else $tsc = "$".$totalsellcomm;
      echo "        <td class=\"right\">".$tsc."<td/>\n";
      echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Payment Recieved:<td/>\n";
      if ($total == 0) $tv = "NONE";
      else $tv = "$" .$totalsale;
      echo "        <td class=\"right\">".$tv."<td/>\n";
	  echo "      </tr>\n";
	  echo "      <tr>\n";
      echo "        <td colspan=\"3\">Total Profit From Buyer And Seller Commission:<td/>\n";
      if ($totalcomm + $totalsellcomm == 0) $tp = "NONE";
      else $tp = "$" .($totalcomm + $totalsellcomm);
      echo "        <td class=\"right\">".$tp."<td/>\n";
	  echo "      </tr>\n";
      echo "    </table>\n";
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

