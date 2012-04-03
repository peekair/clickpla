<?
#TODO ajax functions for shifting referrals

include("admin2/ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables;

function update_upline($to,$from,$referrals1=0,$referrals2=0,$referrals3=0,$referrals4=0,$referrals5=0,$level) {
	global $Db1;
	if($level < 5) {
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
		if(($refered[refered] != $from)) {
			update_upline($refered[refered],$from,0,$referrals1,$referrals2,$referrals3,$referrals4,($level+1));
		}
	}
}

function assign($user, $from, $to) {
	global $Db1, $vip;
	$sql=$Db1->query("SELECT * FROM user WHERE userid='$user'");
	$referral=$Db1->fetch_array($sql);
	$sql=$Db1->query("UPDATE user SET refered='$to' WHERE username='$referral[username]'");
	$sql=$Db1->query("INSERT INTO logs SET username='".$from."', log='Shifted (".$referral[username].") To ($to) ($vip)', dsub='".time()."'");
	update_upline($to,$from,1,
		iif($referral['referrals1']=="",0,$referral['referrals1']),
		iif($referral['referrals2']=="",0,$referral['referrals2']),
		iif($referral['referrals3']=="",0,$referral['referrals3']),
		iif($referral['referrals4']=="",0,$referral['referrals4']),
	1);
	return $referral[username];
}

if($_REQUEST['shift'] == 1) {
	$error=false;
	$select = $_REQUEST['referralsList'];
	$touser = mysql_real_escape_string($_REQUEST['touser']);
	if($Db1->querySingle("SELECT COUNT(userid) as total FROM user WHERE username='{$touser}' ","total") == 1) {
		if(count($select) != 0) {
			for($x=0; $x<count($select); $x++) {
				$usrname=assign($select[$x], $user[username], $touser);
				$thelistr.="<li>$usrname</li>";
			}
			echo "<div class=\"success\">The following referrals were shifted to the account: <strong>$touser</strong> <ul>$thelistr</ul> </div>";
		}
		else $error="There were no referrals selected!";
	}
	else $error = "Could not find the username you entered.";
	if($error) {
		echo "<div class=\"error\">{$error}</div>";
	}
}

$sql=$Db1->query("SELECT * FROM user WHERE refered='$user[username]' ORDER BY last_act DESC");
if($Db1->num_rows() != 0) {
	for($x=0; ($dluser=$Db1->fetch_array($sql)); $x++) {
		$totals[level1]++;
		$totals[level2]+=$dluser[referrals1];
		$totals[level3]+=$dluser[referrals2];
		$totals[level4]+=$dluser[referrals3];
		$totals[level5]+=$dluser[referrals4];

		$downline.="
			<tr>
				<td><input type=\"checkbox\" value=\"$dluser[userid]\" name=\"referralsList[]\"></td>
				<td>$dluser[username]</td>
				<td align=\"center\">$dluser[referrals1]</td>
				<td align=\"center\">$dluser[referrals2]</td>
				<td align=\"center\">$dluser[referrals3]</td>
				<td align=\"center\">$dluser[referrals4]</td>
				<td align=\"center\">".iif($dluser[last_act]!="", date('l, F j Y', @mktime(0,0,$dluser[last_act],1,1,1970)), "")."</td>
			</tr>
		";
	}
?>

<form action="#" method="post" onsubmit="mm.referrals_shift(); return false" id="referrals_form">
	<table class="tableData">
		<tr>
			<th><input type="checkbox" value="1" id="allbox" onClick="mn.referrals_massCheck()"></th>
			<th><b>Level 1</b></th>
			<th><b>2</b></th>
			<th><b>3</b></th>
			<th><b>4</b></th>
			<th><b>5</b></th>
			<th><b>Last Activity</b></th>
		</tr>
		<?=$downline;?>

		<tr>
			<th colspan=7><b>Totals</b></th>
		</tr>

		<tr>
			<th></th>
			<th><?=$totals[level1];?></th>
			<th><?=$totals[level2];?></th>
			<th><?=$totals[level3];?></th>
			<th><?=$totals[level4];?></th>
			<th><?=$totals[level5];?></th>
			<th></th>
		</tr>
	</table>

	<p>Shift Checked Referrals To Account: <input type="text" name="touser" value=""><input type="submit" value="Shift Referrals"></p>

</form>

<? } else { ?>
<div class="notice">This member does not have any referrals.</div>
<? } ?>

