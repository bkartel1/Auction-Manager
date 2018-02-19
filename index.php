<?php
include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass);
mysqli_select_db($db);
$errs = array();
$cons = array();
$errs2 = array();
$cons2 = array();

$servername = "spez.tv";
$username = "speztvauction";
$password = "md8pg^XR_V9C";
$dbname = "AMERICANAUCTION";


// Create connection
$conn = new mysqli($url, $user, $pass, $db);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$action = filter_input(INPUT_GET, "action");

if ($action == "auction"){
$Auctiondb = filter_input(INPUT_POST, "auctiondb", FILTER_SANITIZE_SPECIAL_CHARS);
$adb = '$Adb';
$adbi = '$Adbi';
$paren = '"';
$thing = ';';
$users = 'users';
$items = 'items';
$auction = '$Auction';
$fp = fopen('config.php', 'w');
fwrite($fp, '<?php');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, '$url = "spez.tv";');
fwrite($fp, "\n");
fwrite($fp, '$db = "AMERICANAUCTION";');
fwrite($fp, "\n");
fwrite($fp, '$user = "speztvauction";');
fwrite($fp, "\n");
fwrite($fp, '$pass = "md8pg^XR_V9C";');
fwrite($fp, "\n");
fwrite($fp, "$adb = $paren$Auctiondb$users$paren$thing");
fwrite($fp, "\n");
fwrite($fp, "$adbi = $paren$Auctiondb$items$paren$thing");
fwrite($fp, "\n");
fwrite($fp, "$auction = $paren$Auctiondb$paren$thing");
fwrite($fp, "\n");
fwrite($fp, 'date_default_timezone_set("America/New_York");');
fclose($fp);

}if ($action == "newauction") {
$AuctionName = filter_input(INPUT_POST, "AuctionName", FILTER_SANITIZE_SPECIAL_CHARS);
$line = '|';
$items = 'items';
$users = 'users';
// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS $AuctionName$items (
  `lot_no` varchar(11) DEFAULT NULL,
  `buyer_id` varchar(11) DEFAULT NULL,
  `seller_id` varchar(11) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `title` text,
  `paid` varchar(11) DEFAULT NULL,
  `seller_paid` varchar(11) DEFAULT NULL,
  `qty` varchar(22) DEFAULT '1',
  `reserve` varchar(22) DEFAULT NULL,
  `bundle` varchar(22) NOT NULL,
  `absentee` varchar(22) DEFAULT NULL,
  `absentee_bidder` varchar(22) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1";
if ($conn->query($sql) === TRUE) {
    array_push($cons, "Successfully Created Item Database for ".$AuctionName."!");
} else {
    array_push ($errs, "Couldn't Create Item Database. Please try again.");
}
$sql1 = "CREATE TABLE IF NOT EXISTS $AuctionName$users (
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `birth` varchar(11) NOT NULL,
  `street` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `zip` varchar(11) NOT NULL,
  `id` varchar(20) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `buyer_id` varchar(11) DEFAULT NULL,
  `seller_id` varchar(11) DEFAULT NULL,
  `email` text,
  `tax` decimal(5,3) NOT NULL,
  `taxid` varchar(30) DEFAULT NULL,
  `buyer_commission` varchar(11) DEFAULT NULL,
  `seller_commission` varchar(11) DEFAULT NULL,
  `paid` varchar(20) NOT NULL,
  `seller_paid` varchar(11) NOT NULL,
  `seller_check` varchar(22) NOT NULL,
  `notes` longtext NOT NULL,
  `setup` varchar(22) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1";
if ($conn->query($sql1) === TRUE) {
    array_push($cons, "Successfully Created User Database for ".$AuctionName."!");
} else {
    array_push ($errs, "Couldn't Create User Database. Please try again.");
}
$filename = "auctionselect.txt";
$fd = fopen ($filename, "r");
$contents = fread ($fd, filesize ($filename));
fclose ($fd);
$fp = fopen("auctionselect.txt","w+");
fwrite ($fp,"$AuctionName$line");
fclose ($fp);
$fp = fopen("auctionselect.txt","a");
fwrite ($fp,"\n$contents");
fclose ($fp);
}
?><!DOCTYPE html>
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

	  </div>
	 </div>
	 <p>You Must Select An Auction From Below To Begin The Last Auction Used Is Displayed By Default</p>
	 <form action="index.php?action=auction" method="post" name="items">
<select name="auctiondb">
<option selected="selected"><?php echo $Auction ?></option>
<?php
// define file
$file = 'auctionselect.txt';

$handle = @fopen($file, 'r');
if ($handle) {
   while (!feof($handle)) {
       $line = fgets($handle, 4096);
       $item = explode('|', $line);
       echo '<option value="' . $item[0] . '">' . $item[0] . '</option>';
   }
   fclose($handle);
}
?>
</select>
<input type="submit" name="submit" value="Submit" />
</form>
<p>Create A New Auction Below</p>
      <form action="index.php?action=newauction" method="POST">
        <table>
          <tr>
            <td><label for="AuctionName">New Auction Name</label></td>
            <td><input type="text" id="AuctionName" name="AuctionName"/><br/></td>
            <td colspan="5" style="text-align: right;">
			<input type="submit" value="Create New Auction"/><br/>
            </tr>
            </td>
          </tr>
        </table>
      </form>
	 </div>

    <footer>
      Christopher Speziali, 2017 This software copyright falls under the MIT
      License, meaning it is provided without warranty of any kind and may be
      modified or redistributed at the will of user.
    </footer>
  </body>
</html>
<?php
mysql_close($connection);
?>
