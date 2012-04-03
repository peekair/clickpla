<?
$includes[title]="Issue A Warning";
//**S**//

if($action == "add") {
$sql=$Db1->query("INSERT INTO warnings SET username='".addslashes($username3)."' , title='".addslashes($title)."' , dsub='".time()."', warning='".addslashes($warning)."'");
$sql=$Db1->query("UPDATE user SET warnings= warnings+1 WHERE username='".addslashes($username3)."'"); 

echo "<font color=\"darkgreen\">You issued a warning to ".addslashes($username3)."</font>";
}

$includes[content]="

<form method=\"post\" action=\"admin.php?view=admin&ac=givewarnings&action=add&".$url_variables."\">
<table>
	<tr>
		<td>Username</td>
		<td><input type=\"text\" name=\"username3\"></td>
	</tr>
	<tr>
		<td>Warning Title</td>
		<td><input type=\"text\" name=\"title\"></td>
	</tr>
	<tr>
		<td colspan=\"2\">Reason:<br><textarea name=\"warning\" cols=\"25\" rows=\"5\"></textarea></td>
	</tr>
	<tr>
		<td align=\"center\" colspan=\"2\"><input type=\"submit\" value=\"Add Warning\"></td>
	</tr>
</table>
<br><br><br>
<table>
	<tr>
		<td>Amount of warnings allowed before an account is suspended: </td>
		<td><font color=\"red\">$settings[nomfw]</font> </td></tr><tr>
		<td><font color=\"darkgreen\">You can change this on the Site Settings page</font></td>
	</tr>
	
</table>
</form>
";
//**E**//
?>