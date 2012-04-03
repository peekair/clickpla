<?

$includes['title']="Purge old Featured Ads";

if($_POST['days'] > 0) {
	$days = $_POST['days'];
	$secs = (time()-(60*60*24*$days));
	

	$Db1->query("DELETE FROM fads WHERE credits=0 and dsub<{$secs}");
	echo "<p>Done!</p>";
}


?>

<p>This tool will delete Featured Ads that have are over a certain number of days old and that have no credits left.</p>

<form action="admin.php?ac=purgefads&<?=$url_variables;?>" method="POST">
Age to delete: <input type="text" name="days" size="3" value="30" /> days<br/>
<input type="submit" value="Purge">
</form>