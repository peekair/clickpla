<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
	<title>Report Ad</title>
</head>
<body>
<?

if(!($id > 0)) error("There was a problem finding the specified ad in our system :( ");

if($Db1->querySingle("SELECT COUNT(id) as total FROM reports WHERE adid='$id' and type='{$type}'","total") > 0) {
	$Db1->query("UPDATE reports SET reports=reports+1 WHERE adid='{$id}' and type='{$type}' ");	
	echo "<h3>Thank you!</h3><p>Thank you for making this report. <a href=\"javascript:window.close();\">Close This Window</a></p>";
}
elseif($_GET['submit']) {
	$ad = $Db1->query_first("SELECT * FROM ".$adTables[$type]." WHERE id='{$id}'");
	$title=$ad['title'];
	$target=$ad['target'];
	$placed_by=$ad['username'];
	$other=$_POST['other'];
	$sql=$Db1->query("INSERT INTO reports SET
		adid='{$id}',
		username='{$username}',
		reason='".mysql_real_escape_string($reason)."',
		other='".mysql_real_escape_string($other)."',
		reports='1',
		title='$title',
		target='$target',
		placed_by='$placed_by',
		type='{$type}'
	");
	echo "<h3>Thank you!</h3><p>Thank you for making this report. <a href=\"javascript:window.close();\">Close This Window</a></p>";
}

else { ?>

<h3>Report a Site</h3>
<form action="gpt.php?v=report&id=<?=$id;?>&submit=1&<?=$url_variables;?>" method="POST">

<p>Reason: <select name="reason">
<option value="Inappropriate Content">Inappropriate Content</option>
<option value="Frame Abuse">Frame Abuse</option>
<option value="Popup Abuse">Popup Abuse</option>
<option value="Virus/Spyware">Virus/Spyware</option>
<option value="Other">Other (Please Specify)</option>
</select></p>
<p>Additional Information: <textarea name="other" cols="50" rows="6"></textarea></p>

<p><input name="submit" type="submit" value="Submit"><input name="Reset" type="reset" value="Reset"></p>

</form>

<? }



?>


</body>
</html>