<?
$includes[title]="Retract PTP Credits";
//**VS**//$setting[ce]//**VE**//
//**S**//
$sql=$Db1->query("SELECT * FROM popups WHERE id='$id'");
$thisad=$Db1->fetch_array($sql);

if($action == "retract") {
	if($credits < 1) {
		$error_msg="You must enter at least 1 credit!";
	}
	else if($thisad[username] != $username) {
		$error_msg="You do not have permission to edit this!!";
	}
	else {
		if($credits > $thisad[credits]) {
			$credits=$thisad[credits];
		}
		$sql=$Db1->query("UPDATE popups SET credits=credits-$credits WHERE id='$id'");
		$sql=$Db1->query("UPDATE user SET popup_credits=popup_credits+$credits WHERE username='$username'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=myads&adtype=popups&".$url_variables."");
	}
}


if(($thisad['class'] != "P") || ($thisad[forbid_retract] != 1)) {
	$includes[content]="
	".iif($error_msg!="","<font color=\"darkred\"><b>$error_msg</b></font>")."
	<br />
<div align=\"center\">
<form action=\"index.php?view=account&ac=retract_credits_ptp&action=retract&".$url_variables."\" method=\"post\">
<input type=\"hidden\" value=\"$id\" name=\"id\">
<table>
	<tr>
		<td>Title: </td>
		<td>$thisad[title]</td>
	</tr>
	<tr>
		<td>Url: </td>
		<td><a href=\"$thisad[target]\" url=\"_blank\">$thisad[target]</a></td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td>$thisad[credits]</td>
	</tr>
	<tr>
		<td colspan=2>Credits To Retract: <input type=\"text\" name=\"credits\" value=\"$thisad[credits]\" size=5></td>
	</tr>
	<tr>
		<td align=\"right\" colspan=2><input type=\"submit\" value=\"Retract\"></td>
	</tr>
</table>
</form>
</div>
";
}
else {
	$includes[content]="You cannot retract the credits from this surf site!";
}
//**E**//

?>