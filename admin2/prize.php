<?
$sql=$Db1->query("SELECT username FROM user WHERE verified='1' ORDER BY RAND() LIMIT 75");
while($user = $Db1->fetch_array($sql)) {
	$Db1->query("UPDATE user SET balance=balance+1 WHERE username='$user[username]'");
	$includes[content].="$user[username]<br />";
}

?>