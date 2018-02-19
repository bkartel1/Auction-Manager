 <?php
$servername = "spez.tv";
$username = "speztvauction";
$password = "md8pg^XR_V9C";
$dbname = "speztv_auction";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$newline = 'may18|';
//if ($action == "newauction") { //create new auction
  //$newname = filter_input(INPUT_POST, "Newname", FILTER_SANITIZE_SPECIAL_CHARS);
// sql to create table 
$sql = "CREATE TABLE IF NOT EXISTS may18items (
  `lot_no` varchar(11) DEFAULT NULL,
  `buyer_id` varchar(11) DEFAULT NULL,
  `seller_id` varchar(11) DEFAULT NULL,
  `price` varchar(11) DEFAULT NULL,
  `title` text,
  `paid` varchar(11) DEFAULT NULL,
  `seller_paid` varchar(11) DEFAULT NULL,
  `qty` varchar(22) DEFAULT '1',
  `reserve` varchar(22) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1";
if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$sql1 = "CREATE TABLE IF NOT EXISTS may18users (
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
  `seller_id` varchar(11) NOT NULL,
  `email` text,
  `tax` decimal(5,3) NOT NULL,
  `taxid` varchar(30) DEFAULT NULL,
  `buyer_commission` varchar(11) DEFAULT NULL,
  `seller_commission` varchar(11) DEFAULT NULL,
  `paid` varchar(20) NOT NULL,
  `seller_paid` varchar(11) NOT NULL,
  `seller_check` varchar(22) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1";
if ($conn->query($sql1) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$filename = "auctionselect.txt";
$fd = fopen ($filename, "r");
$contents = fread ($fd, filesize ($filename));
fclose ($fd);
$fp = fopen("auctionselect.txt","w+");
fwrite ($fp,"$newline");
fclose ($fp);
$fp = fopen("auctionselect.txt","a");
fwrite ($fp,"\n$contents");
fclose ($fp);
$conn->close();
?> 
