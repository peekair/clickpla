<?
$includes[title]="Premium Memberships";
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

if($LOGGED_IN == true) {
	if($thismemberinfo[type] != 1) {
		$top="You are currently a basic member! Upgrade and start getting better benefits today!";
	}
	else {
		$sql=$Db1->query("SELECT * FROM memberships WHERE id='$thismemberinfo[membership]'");
		for($x=0; $membership=$Db1->fetch_array($sql); $x++) {
			$feats="";
			$sql2=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$membership[id]' ORDER BY amount");
			while($temp=$Db1->fetch_array($sql2)) {
				$feats.="<li>".$temp[amount]."  ".$temp[title]." ".
										iif($temp[time_type]=="U","Upon Joining").
										iif($temp[time_type]=="D","Daily").
										iif($temp[time_type]=="W","Weekly").
										iif($temp[time_type]=="M","Monthly").
										iif($temp[time_type]=="Y","Yearly");
			}
			$tpackages=explode(",",$membership[packages]);
			$top.="
				<b>$membership[title]</b><br />
				<li>$cursym ".($tpackages[0]*$membership[price])." For ".$tpackages[0]." ".
										iif($temp[time_type]=="D","Day").
										iif($temp[time_type]=="W","Week").
										iif($temp[time_type]=="M","Month").
										iif($temp[time_type]=="Y","Year").
										iif($temp[time_type]=="L","Lifetime")." Membership
				<li>".($membership[downline_earns]*100)."% Downline Earnings
					$feats
";
		}
	}
}

$sql=$Db1->query("SELECT * FROM memberships WHERE active='1' ORDER BY `order`");
for($x=0; $membership=$Db1->fetch_array($sql); $x++) {
	if($x%2 == 0) {
		$list.="
		</tr>
		<tr>
			<td height=10></td>
		</tr>
		<tr>";
	}
	if($x%2 == 1) {
		$list.="<td></td>";
	}
	$feats="";
	$sql2=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$membership[id]' ORDER BY amount");
	while($temp=$Db1->fetch_array($sql2)) {
		$feats.="<li>".$temp[amount]."  ".$temp[title]." ".
								iif($temp[time_type]=="U","Upon Joining").
								iif($temp[time_type]=="D","Daily").
								iif($temp[time_type]=="W","Weekly").
								iif($temp[time_type]=="M","Monthly").
								iif($temp[time_type]=="Y","Yearly");
	}
	$tpackages=explode(",",$membership[packages]);
	$list.="
	<td valign=\"top\"  style=\"border: 1px ".iif($membership[id] == $hl, "orange","black")." solid;\">
		<b  class=\"textHL1\">$membership[title]</b><br />
		<li style=\"color: darkgreen\">$cursym ".($tpackages[0]*$membership[price])." For ".$tpackages[0]." ".
								iif($membership[time_type]=="D","Day").
								iif($membership[time_type]=="W","Week").
								iif($membership[time_type]=="M","Month").
								iif($membership[time_type]=="Y","Year").
								iif($membership[time_type]=="L","Lifetime")." Membership
		<li>".($membership[downline_earns]*100)."% Downline Earnings
		".iif(SETTING_PTP == true, "<li>$cursym ".number_format($membership[ptp]*1000,2)." PTP CPM")."
		".iif($membership[purchase_bonus]>0,"<li>$membership[purchase_bonus]% Bonus Of Referral's Purchases")."
		".iif($membership[upgrade_bonus]>0,"<li>$membership[upgrade_bonus]% Bonus When Referrals Upgrade")."
		$feats<br /><br />
		<div align=\"right\"><input type=\"button\" value=\"Purchase Membership\" onclick=\"location.href='index.php?view=account&ac=buywizard&step=2&ptype=upgrade&id=$membership[id]&".$url_variables."'\">
		".iif(($LOGGED_IN==true) && ($thismemberinfo[type]==1),"<br /><small>Your current membership status will be cancelled upon upgrading to this membership</small>")."
		</div>
	</td>";
}


$includes[content]="
<div style=\"text-align: center;\">
<table  cellpadding=5>
	".iif($LOGGED_IN==true,"
	<tr>
		<td colspan=3 valign=\"top\" align=\"center\">
		<b class=\"textHL1\">Your Membership</b><br />
			<table cellpadding=10>
				<tr>
					<td style=\"border: 1px black solid;\">$top</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height=20></td>
	</tr>")."
	<tr>
		<td colspan=3 align=\"center\"><b class=\"textHL1\">Memberships Available For Purchase</b><br /></td>
	</tr>
	<tr>
		$list
	</tr>
</table>
</div>
";

?>
