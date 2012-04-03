<?
$includes[title]="Delete Email";
//**VS**//$setting[ptr]//**VE**//
//**S**//
if($step == 2) {
	if($action == "Delete") {
		$sql=$Db1->query("SELECT * FROM emails WHERE id='$id'");
		$email=$Db1->fetch_array($sql);
		$sql=$Db1->query("DELETE FROM emails WHERE id='$id'");
		if($retract == 1) $sql=$Db1->query("UPDATE user SET ptr_credits=ptr_credits+$email[credits] WHERE username='$email[username]'");
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}
else {
	$includes[content]="
<form action=\"admin.php?view=admin&ac=delete_email&step=2&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to delete this?')\">
Return Credits To User's Account? <input type=\"checkbox\" value=\"1\" name=\"retract\"><br />
<input type=\"submit\" value=\"Delete\" name=\"action\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"submit\" value=\"Cancel\">
</form>
	";
}
//**E**//
?>
