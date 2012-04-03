<?

$includes['title']="Purge Failed Cheat Checks";
	
	$Db1->query("DELETE FROM cheat_failed");
	echo "<p>All failed Cheat Checks Deleted!</p>";



?>

<p>This tool  deletes all failed cheat checks from the database</p>

