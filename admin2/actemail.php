<?
   
$includes[title]="Activate Ads";
//**VS**//$setting[ptre]//**VE**//
if($action == "update") {
	for($x=0; $x<count($ssite); $x++) {
		$Db1->query("UPDATE emails SET decline='$decline', active='$ssite[$x]' WHERE id='$siteid[$x]'");
	}
}

$sql=$Db1->query("SELECT * FROM emails WHERE active='0' ORDER BY credits DESC");
for($x=0; $site=$Db1->fetch_array($sql); $x++) {
	$list.="
		<tr onclick=\"this.bgColor='lightyellow'\">
			<td><a href=\"frame.php?id=$site[id]&type=emails&openid=$x\" target=\"_blank\"><b>$site[title]</b><br />$site[target]</a><br />Credits: $site[credits]</td>
			<td>
				<input type=\"hidden\" name=\"siteid[$x]\" value=\"$site[id]\">
				<input type=\"radio\" name=\"ssite[$x]\" value=\"1\" id=\"radioidapprove[$x]\">Activate<br />
				<input type=\"radio\" name=\"ssite[$x]\" value=\"0\" checked=\"checked\">Not Active<br />
				<input type=\"radio\" name=\"ssite[$x]\" value=\"2\" id=\"radioiddeny[$x]\">Deny Approval
			</td>
		</tr><td>Ad Decline Message : <input type=\"text\" name=\"decline\" value=\"\"><br><small>This is for displaying a message as to why the ad is denied.<br>Leave blank if approving the ad.</small>
		<tr>
			<td colspan=2><hr></td>
		</tr>
	";
}

$includes[content]="
<script>
function approve(id) {
	document.getElementById('radioidapprove['+id+']').click();
}
function deny(id) {
	document.getElementById('radioiddeny['+id+']').click();
}
</script>

<form action=\"admin.php?view=admin&ac=actemail&action=update&".$url_variables."\" method=\"post\" name=\"actform\">
<table width=\"100%\">
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Update\"></td>
	</tr>
	<tr>
		<td colspan=2><hr></td>
	</tr>
	$list
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Update\"></td>
	</tr>
</table>
</form>
";

?>
