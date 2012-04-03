<?

$includes['title']="Purge Unprocessed Orders";
	
	$Db1->query("DELETE FROM orders WHERE paid=0");
	echo "<p>Done!</p>";



?>

<p>All Unprocessed orders have been cleared from the logs</p>
<br>
<div align="left"><font size="4"><a href="admin.php?ac=unpaidOrders&".$url_variables.">
Return to Unprocessed Orders</a></div></font>