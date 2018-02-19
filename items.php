<?php
include_once 'config.php';

$con=mysqli_connect($url, $user, $pass, $db);

// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM $Adbi ORDER BY seller_id");



echo "	<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>\n";
echo "	<script src='http://spez.tv/auction/src/jquery.table2excel.js'></script>\n";
echo "  <table class='table2excel' data-tableName='Overall' border='1'>
<tr>
<th>Seller ID</th>
<th>Lot Number</th>
<th>Title</th>
<th>Buyer ID</th>
<th>Price</th>
<th>Reserve</th>
<th>Bundle Or Table</th>
<th>Payment Status</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" .$row['seller_id']. "</td>";
echo "<td>" .$row['lot_no']. "</td>";
echo "<td>" .$row['title']. "</td>";
echo "<td>" .$row['buyer_id']. "</td>";
echo "<td>" .$row['price']. "</td>";
echo "<td>" .$row['reserve']. "</td>";
echo "<td>" .$row['bundle']. "</td>";
echo "<td>" .$row['paid']. "</td>";
echo "</tr>";
}
echo "</table>";

    ?>
  <button>Export To Excell</button>
  <script>
			$("button").click(function() {
				$(".table2excel").table2excel({
					// eclude CSS class
					exclude:".noExl",
					name: "Auction Results",
					filename: "Items Report",
					fileext: ".xls",
				});
			});
		</script>
  </body>
</html>
<?php
mysqli_close($con);
?>

