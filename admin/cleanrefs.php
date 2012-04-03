<?
$includes[title]="Find Missing Referrals";

$sql=$Db1->query("SELECT * FROM user");
while($temp=$Db1->fetch_array($sql)) {
	if($temp[refered] != "") {
		$sql2=$Db1->query("SELECT userid FROM user WHERE username='".addslashes($temp[refered])."'");
		if($Db1->num_rows() == 0) {
			if($action == "clean") {
				$Db1->query("UPDATE user SET refered='' WHERE username='".addslashes($temp[username])."'");
				$Db1->query("UPDATE user SET upline_earnings='0' WHERE username='".addslashes($temp[username])."'");
				$Db1->query("UPDATE user SET clicksref='0' WHERE username='".addslashes($temp[username])."'");
				$Db1->query("UPDATE user SET refstat='0' WHERE username='".addslashes($temp[username])."'");
			}
			$list.="
				<tr>
					<td>$temp[username]</tD>
					<td>$temp[refered]</tD>
				</tr>
			";
		}
	}
}

if($action == "clean") {
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=cleanrefs&".$url_variables."");
}

$includes[content]="
<a href=\"admin.php?view=admin&ac=cleanrefs&action=clean&".$url_variables."\">Clean All</a><br /><br />
<table>
	<tr>
		<td width=100><b>Username</b></td>
		<td><b>False Referrer</b></td>
	</tr>
	$list
</table>

";


?>
