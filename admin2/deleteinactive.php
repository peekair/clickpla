<?
    function deleteUser1($id) {
	global $Db1;
		$sql=$Db1->query("SELECT * FROM user WHERE userid='$id'");
		$userinfo=$Db1->fetch_array($sql);

		$Db1->query("DELETE FROM ads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM emails WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM ptrads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM ptsuads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM popups WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM xsites WHERE username='$userinfo[username]'");

		$Db1->query("DELETE FROM banners WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM fbanners WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM fads WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM flinks WHERE username='$userinfo[username]'");

		$Db1->query("UPDATE user SET refered='' WHERE refered='".$userinfo[username]."' ");
		$Db1->query("UPDATE user SET notes='\n---------------\nDeleted By Admin' WHERE userid='$userinfo[userid]'");
		$Db1->query("INSERT INTO user_deleted SELECT * FROM user WHERE userid='$userinfo[userid]'");
		$Db1->query("DELETE FROM user WHERE userid='$userinfo[userid]'");
}


if(($action == "delete") && ($days > 10)) {
	$sql = $Db1->query("SELECT * FROM user WHERE last_act<".(time()-(60*60*24*$days))."");
	if($Db1->num_rows() != 0) {
		while($userinfo=$Db1->fetch_array($sql)) {
			deleteUser1($userinfo['userid']);
			$list.="Deleted $userinfo[username]<br />";
		}
	}
	$includes[content]="$list";
}
else {

$sql = $Db1->query("SELECT COUNT(userid) as total, SUM(balance) as balance, SUM(link_credits) as links FROM user WHERE last_act<".(time()-(60*60*24*90))."");
$temp=$Db1->fetch_array($sql);

$includes[content]="
Inactive Accounts for Last 90 Days:<br />
Accounts: $temp[total]<br />
Balance: $temp[balance]<br />
Links Credits: $temp[links]<br />


<form action=\"admin.php?view=admin&ac=deleteinactive&action=delete&".$url_variables."\" method=\"post\">
Delete Accounts Inactive For <input type=\"text\" name=\"days\" value=\"60\" size=3> Days<br />
<input type=\"submit\" value=\"Delete\">
</form>
";
}
?>
