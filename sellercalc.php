<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Seller Price and Comission Calculator</title>
</head>

<body>

<p>Sellers Auction Price Calculator</p>
<form name="form1" method="post" action="">

Price:<br>
<input type="text" name="price" value="<?php echo $_POST['price']; ?>">
(example: 49.00) <br>


<br>
Enter Seller Commission Rate:<br>
<input type="text" name="sellercomm_rate" value="<?php echo $_POST['sellercomm_rate']; ?>">
(example: 8.25) <br>


<br>
<input type="submit" name="Submit" value="Submit">
</form>
<hr width="200" align="left">

<?php
$Subtotal = $_POST['price'];
$Tax = round( (($_POST['price'] * $_POST['tax_rate']) / 100 ), 2);
$Sellercomm = round( (($_POST['price'] * $_POST['sellercomm_rate']) / 100 ), 2);
$Total = ($Subtotal - $Sellercomm);
?>
Subtotal: $<?php echo $Subtotal; ?><br>
Seller Commission: $<?php echo $Sellercomm; ?><br>
Total: $<?php echo $Total; ?><br>

<p align="center"><a href="admin.php">Return to Auction System &gt;&gt;</a> </p>

</body>
</html> 


