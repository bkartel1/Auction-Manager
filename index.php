<?php
include_once 'config.php';

$connection = mysqli_connect($url, $user, $pass);
mysqli_select_db($db);
$errs = array();
$cons = array();
$errs2 = array();
$cons2 = array();

$servername = "localhost";
$username = "cspez";
$password = "Tobster1";
$dbname = "auction";


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
fwrite($fp, '$url = "localhost";');
fwrite($fp, "\n");
fwrite($fp, '$db = "auction";');
fwrite($fp, "\n");
fwrite($fp, '$user = "cspez";');
fwrite($fp, "\n");
fwrite($fp, '$pass = "Tobster1";');
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
  `setup` varchar(22) DEFAULT NULL,
  `disposal` varchar(11) DEFAULT NULL,
  `disposal_note` varchar(500) NOT NULL
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

    <?php
    include "header.php";
    ?>

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
