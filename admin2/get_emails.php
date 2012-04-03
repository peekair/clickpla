<?
$includes[title]="Get Emails";

if($action == "get") {
	echo "<textarea cols=40 rows=50>";
	$sql=$Db1->query("SELECT username, email FROM user WHERE verified='1'");
	while($temp = $Db1->fetch_array($sql)) {
		echo "$temp[email], $temp[username]\n";
	}
	echo "</textarea>";
}

$includes[content]="<a href=\"admin.php?view=admin&ac=get_emails&action=get&".$url_variables."\">Compile List</a>";

?>
