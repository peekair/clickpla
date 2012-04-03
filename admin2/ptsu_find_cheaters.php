<?


function makeSignupList($sql) {
	global $Db1;
	$found=$Db1->num_rows();
	
	$list.="
	<form action=\"admin.php?view=admin&ac=ptsu_find_cheaters&mode=length&action=deny&".$url_variables."\" method=\"post\">
		<div style=\"float: right\"><a href=\"admin.php?view=admin&ac=ptsu_find_cheaters&".$url_variables."\">Back To Cheater Tools</a></div>
		<b>$found Signups Found!</b><hr>
		<table class=\"tableStyle2\">
			<tr>
				<td style=\"width: 20px;\"></td>
				<td><b>Welcome Email</b></td>
				<td><b>User</b></td>
				<td><b>Offer</b></td>
				<td><b>Signup</b></td>
			</tr>";
	for($x=0; $temp = $Db1->fetch_array($sql); $x++) {
		$list.="
			<tr>
				<td  style=\"width: 20px;\">
					<input type=\"hidden\" name=\"signupIndex[$x]\" value=\"$temp[id]\">
					<input type=\"checkbox\" name=\"signupItems[$x]\" value=\"1\" checked>
				</td>
				<td>$temp[welcome_email]</td>
				<td><a href=\"admin.php?view=admin&ac=edit_user&uname=$temp[username]&".$url_variables."\">$temp[username]</a></td>
				<td><a href=\"admin.php?view=admin&ac=&".$url_variables."\">$temp[ptsu_id]</a></td>
				<td><a href=\"admin.php?view=admin&ac=&".$url_variables."\">$temp[id]</a></td>
			</tr>
		";
	}
	$list.="		
		</table>
		<input type=\"submit\" value=\"Deny Selected\">
	</form>";
	return $list;
}





if($mode == "length") {
	if($action == "deny") {
		for($x=0; $x<count($signupItems); $x++) {
			if($signupItems[$x] == 1) {
				processSignup($signupIndex[$x], 3);
			}
		}
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=ptsu_find_cheaters&mode=length&".$url_variables."");
		exit;
	}
	$sql=$Db1->query("SELECT * FROM ptsu_log WHERE LENGTH(welcome_email) < 60 and (status=0 or status=2) ORDER BY username");
	$includes[content]=makeSignupList($sql);
}
else {
	$includes[content]="
	<menu>
		<li><b><a href=\"admin.php?view=admin&ac=ptsu_find_cheaters&mode=length&".$url_variables."\">Small Welcome Emails</a></b><br />Do a search for welcome emails that are under 50 letters long, returns most false signups where member just enters their email address.
	</menu>
	
	";
}


?>
