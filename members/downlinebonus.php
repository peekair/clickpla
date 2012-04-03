<?
//##############################################
//#            AURORAGPT Script Copyright owned by Mike Pratt              #
//#                        ALL RIGHTS RESERVED 2007-2009                        #
//#                                                                                                 #
//#        Any illegal use of this script is strictly prohibited unless          # 
//#        permission is given by the owner of this script.  To sell          # 
//#        this script you must have a resellers license. Your site          #
//#        must also use a unique encrypted license key for your         #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise         #
//#        it will be considered as unlicensed and can be shut down    #
//#        legally by Illusive Web Services. By using AuroraGPT       #
//#        script you agree not to copy infringe any of the coding     #
//#        and or create a clone version is also copy infringement   #
//#        and will be considered just that and legal action will be   #
//#        taken if neccessary.                                                    #
//#########################################//   
$includes[title]="Claim Bonus";
if(SETTING_SWAP==true) {
if($action == "move"){
$sql=$Db1->query("UPDATE user SET bonusclaims=bonusclaims+1, balance=balance+$settings[bonusclaim] WHERE username='$username'");
}

function update_upline($to,$from,$referrals1=0,$referrals2=0,$referrals3=0,$referrals4=0,$referrals5=0,$level) {
	global $procs, $Db1, $headers, $settings;
	if($level < $settings["ref_levels"]) {
		$sql=$Db1->query("UPDATE user SET
			referrals1=referrals1+$referrals1,
			referrals2=referrals2+$referrals2,
			referrals3=referrals3+$referrals3,
			referrals4=referrals4+$referrals4,
			referrals5=referrals5+$referrals5
		WHERE
		username='$to'
		");
		$sql=$Db1->query("UPDATE user SET
			referrals1=referrals1-$referrals1,
			referrals2=referrals2-$referrals2,
			referrals3=referrals3-$referrals3,
			referrals4=referrals4-$referrals4,
			referrals5=referrals5-$referrals5
		WHERE
		username='$from'
		");
		$sql=$Db1->query("SELECT refered FROM user WHERE username='$to'");
		$refered=$Db1->fetch_array($sql);
		if(($refered[refered] != $username)) {
			update_upline($refered[refered],$from,0,$referrals1,$referrals2,$referrals3,$referrals4,($level+1));
		}
	}
}

function assign($user, $from, $to) {
	global $procs, $Db1, $headers, $settings, $vip;
	$to = mysql_real_escape_string($to);
	$sql=$Db1->query("SELECT * FROM user WHERE userid='$user' and refered='$from' ");
	if($Db1->num_rows() == 1) {
		$referral=$Db1->fetch_array($sql);
		$sql=$Db1->query("UPDATE user SET refered='$to' WHERE username='$referral[username]'");
		$sql=$Db1->query("UPDATE user SET refstat='2' WHERE username='$referral[username]'");
		$sql=$Db1->query("UPDATE user SET upline_earnings='0' WHERE username='$referral[username]'");
		$sql=$Db1->query("UPDATE user SET clicksref='0' WHERE username='$referral[username]'");
		$sql=$Db1->query("INSERT INTO logs SET username='".$from."', log='Shifted (".$referral[username].") To ($to) ($vip)', dsub='".time()."'");
		update_upline($to,$from,1,
			iif($referral['referrals1']=="",0,$referral['referrals1']),
			iif($referral['referrals2']=="",0,$referral['referrals2']),
			iif($referral['referrals3']=="",0,$referral['referrals3']),
			iif($referral['referrals4']=="",0,$referral['referrals4']),
		1);
		return $referral[username];
	}
	else return false;
}


if($action == "move") {
	if(count($select) != 0) {
		for($x=0; $x<count($select); $x++) {
			$sql=$Db1->query("SELECT username FROM user WHERE userid='$select[$x]'");

			$tempuser=$Db1->fetch_array($sql);

			if(($tempuser[username] == $touser) && ($settings[allow_self_ref] != 1)) {
				$thelist.="<li><font color=\"red\">$tempuser[username]</font> : Cannot claim bonus!";
			}
			else {
				$usrname=assign($select[$x], $username, $touser);
				if($usrname) $thelist.="<li>$usrname";
			}
		}
		$includes[content]="The following referrals were swapped for a claim bonus! :<br /><br />$thelist";
	}
}
else {
$clicksleft=1-$user[coclicks];
$balance[ref]=0.00;
$sql=$Db1->query("SELECT SUM(upline_earnings) AS total FROM user WHERE refered='$username'");
$totalrefearn=$Db1->fetch_array($sql);
$balance[ref]+=$totalrefearn[total];

$clicks[ref]=0;
$sql=$Db1->query("SELECT SUM(clicksref) AS total FROM user WHERE refered='$username'");
$totalrefclick=$Db1->fetch_array($sql);
$clicks[ref]+=$totalrefclick[total];

$sql=$Db1->query("SELECT * FROM user WHERE refered='$username' ORDER BY last_act DESC");
if($Db1->num_rows() != 0) {
	for($x=0; $user=$Db1->fetch_array($sql); $x++) {
		$totals[level1]++;
		$totals[level2]+=$user[referrals1];
		$totals[level3]+=$user[referrals2];
		$totals[level4]+=$user[referrals3];
		$totals[level5]+=$user[referrals4];
if($user[type] == 0) $upstats="No";
if($user[type] == 1) $upstats="Yes";


		$downline.="
				<tr class=\"tableHL2\">	<td>	".iif($settings[claimon]==1 && !$user[coclicks]  <$clicksleft,"
						
						<input type=\"checkbox\" value=\"$user[userid]\" name=\"select[]\">
					")."
				$user[username]</td>
					<td>$upstats</td>
					<td>\$$user[upline_earnings]</td>

					".iif($settings["ref_levels"] >= 2," </td>")."
					".iif($settings["ref_levels"] >= 3, "<td align=\"center\">$user[referrals2]</td>")."
					".iif($settings["ref_levels"] >= 4, "<td align=\"center\">$user[referrals3]</td>")."
					".iif($settings["ref_levels"] >= 5, "<td align=\"center\">$user[referrals4]</td>")."
					<td>$user[clicksref]</td>

					<td align=\"center\">".iif($user[last_act]!="", date('l, F j Y', mktime(0,0,$user[last_act],1,1,1970)), "")."</td>
					<td align=\"center\">
					".iif($user[refstat] == 0,"<strong title=\"Referred Referral\">Reffered</strong>")."
					".iif($user[refstat] == 1,"<strong title=\"Purchased Referral\">Purchased</strong>")."
					".iif($user[refstat] == 2,"<strong title=\"Shifted Referral\">Shifted</strong>")."
					".iif($user[refstat] == 3,"<strong title=\"Admin Assigned Referral\">Admin</strong>")."
</td>
				</tr>
		";
	}
	$includes[content]="
<SCRIPT LANGUAGE=\"JavaScript\">
ie = document.all?1:0
function hL(E, C){
	if (ie) {
		if(C.checked) {
			E.bgColor='#C2f1D9';
		}
		else {
			E.bgColor='#DFE6EE';
		}
	}
}

function CA(isOnload) {
	for (var i=0;i<document.frm.elements.length;i++) {
		var e = document.frm.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox')) {
			if (isOnload != 1) {
				if (e.checked != document.frm.allbox.checked) {
					e.click()
				}
				//hL(e, true)
			}
		}
	}
}

function validate2() {
	if(document.frm.touser.value == '') {
		alert('Please enter a username to shift these referrals to!');
		return false;
	}
	else {
		return true;
	}
}
</script>
<form  name=\"frm\" action=\"index.php?view=account&ac=downlinebonus&action=move&".$url_variables."\" method=\"post\" onsubmit=\"return validate2()\">
			<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
				<tr class=\"tableHL1\"><td>
					".iif($settings[claimon]==1 && !$user[coclicks]  <$clicksleft,"<input type=\"checkbox\" value=\"1\" name=\"allbox\" onClick=\"CA()\">")."
					<b>Level 1</b></td>
					<td><b>Premium</b></td>
					<td><b>Earnings</b></td>
					".iif($settings["ref_levels"] >= 2, "<td align=\"center\"><b>2</b></td>")."
					".iif($settings["ref_levels"] >= 3, "<td align=\"center\"><b>3</b></td>")."
					".iif($settings["ref_levels"] >= 4, "<td align=\"center\"><b>4</b></td>")."
					".iif($settings["ref_levels"] >= 5, "<td align=\"center\"><b>5</b></td>")."
					<td><b>Clicks</b></td>
					<td align=\"center\"><b>Last Activity</b> </td>
					<td align=\"center\"><b>Status</b></td>
				</tr>
				$downline

				<tr class=\"tableHL1\">
					<td align=\"center\" colspan=7><b>Totals</b></td>
				</tr>

				<tr class=\"tableHL2\">
					<td></td>
					<td>$totals[level1]</td>
					<td></td>
					".iif($settings["ref_levels"] >= 2, "<td align=\"center\">$totals[level2]</td>")."
					".iif($settings["ref_levels"] >= 3, "<td align=\"center\">$totals[level3]</td>")."
					".iif($settings["ref_levels"] >= 4, "<td align=\"center\">$totals[level4]</td>")."
					".iif($settings["ref_levels"] >= 5, "<td align=\"center\">$totals[level5]</td>")." 
				<td>\$$totalrefearn[total]</td>
				<td>$totalrefclick[total]</td>	
                               
				<td align=\"center\"></td>
				</tr>
			</table>
<br />Please Note :<BR>You will only be able to claim a bonus from a referral if they have reached the minimum required clicks. Please keep in mind, when you check the checkbox next to the referral name and you click claim bonus, it will swap that referral for $settings[bonusclaim] for each referral you swap. <BR><BR>
<div align=\"left\">
Claim Bonus: <input type=\"hidden\" name=\"touser\" value=\" \"><input type=\"submit\" value=\"Claim Bonus\">
</div>
</form>
";
}
else {
	$includes[content]="
You do not have any referrals!
";
}
}

$includes[content]="
Referral URL: <a href=\"http://www.$settings[domain_name]/index.php?ref=$username\">http://www.$settings[domain_name]/index.php?ref=$username</a><br />
<a href=\"index.php?view=account&ac=refapi&".$url_variables."\">Referral API</a>
<br /><br />
$includes[content]";

?>
<? } 
else {
	$includes[content]="This site does not have Swap Referrals 2 Cash enabled. Please contact your script supplier for more information.";
}?>
