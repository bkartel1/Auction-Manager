<?php
include_once 'config.php';

$con=mysqli_connect($url, $user, $pass, $db);

// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con,"SELECT * FROM $Adb");

echo "	<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js'></script>\n";
echo "	<script src='http://spez.tv/auction/src/jquery.table2excel.js'></script>\n";
echo "  <table class='table2excel' data-tableName='Overall' border='1'>
<tr>
<th>Firstname</th>
<th>Lastname</th>
<th>DOB</th>
<th>Phone</th>
<th>ID #</th>
<th>Tax ID #</th>
<th>Email</th>
<th colspan=\"4\">Address</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" .$row['first_name']. "</td>";
echo "<td>" .$row['last_name']. "</td>";
echo "<td>" .$row['birth']. "</td>";
echo "<td>" .$row['phone']. "</td>";
echo "<td>" .$row['id']. "</td>";
echo "<td>" .$row['taxid']. "</td>";
echo "<td>" .$row['email']. "</td>";
echo "<td> ".$row['street']." ".$row['city']." ".$row['state']." ".$row['zip']." </td>";
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
					filename: "Customers Report",
					fileext: ".xls",
				});
			});
		</script>
  </body>
</html>
<?php
mysqli_close($con);
?>
