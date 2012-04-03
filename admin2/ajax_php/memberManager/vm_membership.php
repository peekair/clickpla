<?
include("admin2/ajax_php/memberManager/header.php");
global $user, $id;

$mtype = $_REQUEST['mtype'];
$amount = $_REQUEST['amount'];
$joinbenefits = $_REQUEST['joinbenefits'];


if($_REQUEST['save'] == 1) {
	if($mtype == "basic") {
		$Db1->query("UPDATE user SET type='0', membership='0' WHERE username='$user[username]'");
	}
	else {
		$sql=$Db1->query("SELECT * FROM memberships WHERE id='$mtype'");
		$membership=$Db1->fetch_array($sql);
		if($joinbenefits == 1) {
			$sql=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$mtype' and time_type='U'");
			while(($benefit = $Db1->fetch_array($sql))) {
				if($benefit[type] != "") {
					$sql=$Db1->query("UPDATE user SET $benefit[type]=$benefit[type]+$benefit[amount] WHERE username='$user[username]'");
				}
			}
		}

		$duration=
			(
				iif($membership[time_type] == "D",86400).
				iif($membership[time_type] == "W",604800).
				iif($membership[time_type] == "M",2678400).
				iif($membership[time_type] == "Y",31536000).
				iif($membership[time_type] == "L",2365200000)
			)
		*$amount;

		if(($user[pend] < time())) {
			$pend=time()+$duration;
		}
		else {
			$pend=$user[pend]+$duration;
		}

		$sql=$Db1->query("UPDATE user SET
			type=1,
			membership='$mtype',
			pend='$pend'
			WHERE username='".$user[username]."'
		");
	}
	echo "<div class=\"success\">Your changes have been saved!</div>";
}


$sql=$Db1->query("SELECT * FROM memberships ORDER BY title");
while(($temp=$Db1->fetch_array($sql))) {
	$membershipp[$temp[id]]=$temp[title]." (".
								iif($temp[time_type]=="D","Day").
								iif($temp[time_type]=="W","Week").
								iif($temp[time_type]=="M","Month").
								iif($temp[time_type]=="Y","Year").
								iif($temp[time_type]=="L","Lifetime").
							")";
	$memberlist.="<option value=\"$temp[id]\"".iif(($user[membership]==$temp[id]) && ($user[type]==1)," selected=\"selected\"").">$temp[title] (".
								iif($temp[time_type]=="D","Day").
								iif($temp[time_type]=="W","Week").
								iif($temp[time_type]=="M","Month").
								iif($temp[time_type]=="Y","Year").
								iif($temp[time_type]=="L","Lifetime").
							")\n";
}



echo "

<form action=\"#\" method=\"post\" onsubmit=\"mm.membership_save(); return false;\" id=\"vm_membership_form\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"500\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Membership</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Membership:</td>
					<td>".iif($user[type]==0,"Basic",$membershipp[$user[membership]])."</td>
				</tr>".iif($user[type]==1,"
				<tr class=\"tableHL2\">
					<td>Ends In:</td>
					<td>".floor(($user[pend]-time())/24/60/60)." Days</td>
				</tr>")."
				<tr class=\"tableHL2\">
					<td>Set Membership:</td>
					<td>
					<select name=\"mtype\">
						<option value=\"basic\">Basic
						{$memberlist}
					</select></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Qty:</td>
					<td><input type=\"text\" name=\"amount\" size=3 value=\"1\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Award Join Benefits?:</td>
					<td><input type=\"checkbox\" value=\"1\" name=\"joinbenefits\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Upgrade Member\"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>";

?>