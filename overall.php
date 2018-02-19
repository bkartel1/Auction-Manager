<?php

include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass, $db);
//mysql_select_db($db);

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Overall Report</title>
    <link rel="stylesheet" type="text/css" href="./report.css"/>
  </head>
  <body>
    <p>Overall Report:</p>
    <?php
    
    $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE buyer_id IS NOT NULL;");
    $totalBuyers = mysqli_num_rows($q);
    
    $q = mysqli_query($connection, "SELECT * FROM $Adb WHERE seller_id IS NOT NULL;");
    $totalSellers = mysqli_num_rows($q);
    
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id IS NOT NULL;");
    $totalListings = mysqli_num_rows($q);
    
    $q = mysqli_query($connection, "SELECT tax FROM $Adbi WHERE buyer_id IS NOT NULL;");
    //$totalSales = mysql_num_rows($q);
    
    $totalTaxPrice = 0;
    while ($result = mysqli_fetch_assoc($q)) {
      if ($result["tax"] > 0) {
        $totalTaxPrice = $result["tax"] / 100.0;
       }
      }
    
    $q = mysqli_query($connection, "SELECT * FROM $Adbi WHERE seller_id IS NOT NULL AND buyer_id IS NOT NULL AND price IS NOT NULL;");
    //$totalSales = mysql_num_rows($q);
    
    $totalSales = 0;
    $totalSalePrice = 0;
    while ($result = mysqli_fetch_assoc($q)) {
      if ($result["price"] > 0) {
        $totalSalePrice += $result["price"];
        $totalSales++;
      }
    }
    

    
    ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="http://spez.tv/auction/src/jquery.table2excel.js"></script>
    <table class="table2excel" data-tableName="Overall">
      <tr>
	  </tr>
	  <tr  class="noExl">
        <td colspan="8">--------------------------------------------------------------------------------</td>
      </tr>
      <tr>
        <td>Total Buyers: </td>
        <td><?php echo $totalBuyers; ?></td>
      </tr>
      <tr>
        <td>Total Sellers: </td>
        <td><?php echo $totalSellers; ?></td>
      </tr>
        <td>Total Listings:</td>
        <td><?php echo $totalListings; ?></td>
      </tr>
      <tr>
        <td>Total Sales:</td>
        <td><?php echo $totalSales; ?></td>
      </tr>
      <tr>
        <td>Total Sale Price:</td>
        <td><?php echo "$".$totalSalePrice; ?></td>
      </tr>
      <tr>
        <td>Total Tax Collected:</td>
        <td><?php echo "$".($totalSalePrice * $totalTaxPrice); ?></td>
      </tr>
      <tr>
        <td>Average Listing per Seller: </td>
        <td><?php echo $totalListings / $totalSellers; ?></td>
      </tr>
      <tr>
        <td>Average Sales per Seller: </td>
        <td><?php echo $totalSales / $totalSellers; ?></td>
      </tr>
      <tr>
        <td>Average Sales per Buyer: </td>
        <td><?php echo $totalSales / $totalBuyers; ?></td>
      </tr>
      <tr>
        <td>Average Price per Sale: </td>
        <td><?php echo $totalSalePrice / $totalSales; ?></td>
      </tr>
      <tr>
        <td>Average Price per Listing: </td>
        <td><?php echo $totalSalePrice / $totalListings; ?></td>
      </tr>
    </table>

    <button>Export As Excel Spreadsheet</button>
    <script>
			$("button").click(function() {
				$(".table2excel").table2excel({
					// eclude CSS class
					exclude:".noExl",
					name: "Auction Results",
					filename: "Auction",
					fileext: ".xls",
				});
			});
		</script>
  </body>
</html>
