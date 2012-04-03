
<?
if(!isset($username)) {
	echo "Invalid URL! No Username Detected!";
	exit;
}

function findclick($preclicked, $id) {
	$return=0;
	$preclicked2=explode(":", $preclicked);
	for($x=0; $x<count($preclicked2); $x++) {
		if($preclicked2[$x] == $id) {
			$return=1;
		}
	}
	return $return;
}

@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
@header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
@header("Cache-Control: no-cache, must-revalidate");
@header("Pragma: no-cache");

include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect();

$sql=$Db1->query("SELECT * FROM click_history WHERE username='$username'");
if($Db1->num_rows() != 0) {
	$temp=$Db1->fetch_array($sql);
	$preclicked=$temp[clicks];
}
if($preclicked == "") {
	$preclicked=":0:";
}


$total=0;
$sql=$Db1->query("SELECT * FROM ads WHERE credits>=1 ORDER BY `class`");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
		if(findclick($preclicked, $ad[id]) == 0) {
			$total++;
		}
	}
}
$Db1->sql_close();
?>
<html>
<head>
	<title>Link Notifier</title>
</head>
<body>
<?
if($total != 0) {
	echo "<font color=\"darkblue\">ALERT!</font><br />There Are $total Links Available For You To Click At $settings[domain_name]!<br /><a href=\"http://www.$settings[domain_name]/index.php?view=account&ac=click\">Start Clicking</a>";
}
else if($total == 0) {
	echo "There Are Currently No Links Available For You To Click!";
}


?>
</body>
</html>
