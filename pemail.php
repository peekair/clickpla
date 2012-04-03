<?
//**VS**//$setting[ptr]//**VE**//
$id=$_GET['id'];
if (ereg('[^0-9]', $id)) { echo "Error"; exit; }

$includes[title]="Paid Email View";
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include("includes/globals.php");

//**S**//



$sql=$Db1->query("SELECT * FROM email_history WHERE username='$user'");
if($Db1->num_rows() != 0) {
	$preclicked=$Db1->fetch_array($sql);
} else {
	$Db1->query("INSERT INTO email_history SET username='$user'");
	$sql=$Db1->query("SELECT * FROM email_history WHERE username='$user'");
}
if($preclicked[clicks] == "") {
	$preclicked[clicks]=":";
}


$sql=$Db1->query("UPDATE user SET last_click='".time()."' WHERE username='$user'");

$sql=$Db1->query("SELECT * FROM emails WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if(findclick($preclicked[clicks], $id) == 1) {
	$includes[content]= "<body>You Have Already Clicked This Link Today</body>";
}
else if($ad[credits] <= 0 || ($ad[daily_limit] <= $ad[views_today] && $ad[daily_limit] > 0)  || ($ad[upgrade] == 1 && $thismemberinfo[type]!=1)) {
	$includes[content]= "<body>This Link Is No Longer Available To Click!</body>";
}
else {
	$sql=$Db1->query("DELETE FROM email_browseval WHERE username='$user'");
	$time=time();
	mt_srand((double)microtime()*1000000);
	$num = mt_rand(0,3);


	if(cheat_check("pemail", $id) == false) {
		$ad[target]="cheat.php?id=$id&return=pemail&".$url_variables;
	} else {
		$Db1->query("UPDATE emails SET views=views+1, views_today=views_today+1, credits=credits-1 WHERE id='$id'");
		$Db1->query("UPDATE email_history SET clicks='".$preclicked[clicks].$id.":' WHERE username='$user'");
		$Db1->query("INSERT INTO email_browseval (dsub, username, val) VALUES ('$time','$user','$num')");
	}

	$includes[content]="
<frameset rows=\"73,*\" style=\"border: 1 black;\" noresize=\"noresize\">
<frame name=\"surftopframe\" src=\"pemailtimer.php?pretime=$time&id=$id&user=$user\" scrolling=no marginheight=\"2\" marginwidth=\"2\" noresize=\"noresize\" >
<frame name=\"surfmainframe\" src=\"$ad[target]\" marginheight=\"0\" marginwidth=\"0\" noresize=\"noresize\">
</frameset>
	";
}

$Db1->sql_close();
//**E**//
?>
<html>
<head>
<title><?  echo $settings[domain_name]; ?> : Paid To Read Emails : <? echo ucwords(stripslashes($ad[title])); ?></title>
</head>
<? echo $includes[content]; ?>
</html>
<?
exit;
?>