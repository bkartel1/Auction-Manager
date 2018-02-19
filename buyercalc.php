<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Buyer Tax and Comission Calculator</title>
</head>

<body>

<p>Buyers Auction Price Calculator</p>
<form name="form1" method="post" action="">

Price:<br>
<input type="text" name="price" value="<?php echo $_POST['price']; ?>">
(example: 49.00) <br>

<br>
Enter Sales Tax Rate:<br>
<input type="text" name="tax_rate" value="<?php echo $_POST['tax_rate']; ?>">
(example: 8.25) <br>

<br>
Enter Buyer Commission Rate:<br>
<input type="text" name="buyercomm_rate" value="<?php echo $_POST['buyercomm_rate']; ?>">
(example: 8.25) <br>


<br>
<input type="submit" name="Submit" value="Submit">
</form>
<hr width="200" align="left">

<?php
$Subtotal = $_POST['price'];
$Tax = round( (($_POST['price'] * $_POST['tax_rate']) / 100 ), 2);
$Buyercomm = round( (($_POST['price'] * $_POST['buyercomm_rate']) / 100 ), 2);
$Total = ($Tax + $Subtotal + $Buyercomm);
?>
Subtotal: $<?php echo $Subtotal; ?><br>
Buyer Commission: $<?php echo $Buyercomm; ?><br>
Tax : $<?php echo $Tax; ?><br>
Total: $<?php echo $Total; ?><br>

<p align="center"><a href="admin.php">Return to Auction System &gt;&gt;</a> </p>

</body>
</html> 

