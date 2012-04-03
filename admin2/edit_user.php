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
$includes[title]="Manage Member";

//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if($_GET['id'] != "") $id=$_GET['id'];
else if($_POST['id'] != "") $id=$_POST['id'];

$sql=$Db1->query("SELECT * FROM user WHERE ".iif($id!="","userid='$id'",iif($uname!="","username='$uname'")));
if($Db1->num_rows() == 0) {
	$includes[content]="The user could not be found in the database!";
}
else {
$userinfo=$Db1->fetch_array($sql);
$user=$userinfo;
$id=$userinfo[userid];

if($userinfo[last_click] == "") $userinfo[last_click]=0;
if($userinfo[last_act] == "") $userinfo[last_act]=0;
if($userinfo[joined] == "") $userinfo[joined]=0;


$show_permission_fields=0;
if(($thismemberinfo[permission] == 7) && ($username != $user[username])) {
	$show_permission_fields=1;
}

$includes[title]="Manage Member > $user[username]";

function update_upline($to,$from,$referrals1=0,$referrals2=0,$referrals3=0,$referrals4=0,$referrals5=0,$level) {
	global $procs, $Db1, $headers, $settings;
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
		if(($refered[refered] != $username)) {
			update_upline($refered[refered],$from,0,$referrals1,$referrals2,$referrals3,$referrals4,($level+1));
		}
	}
}

function assign($user, $from, $to) {
	global $procs, $Db1, $headers, $settings, $vip;
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


if($action == "edit_pwd") {
	if($new_pwd != "") {
		$sql=$Db1->query("UPDATE user SET password='".md5($new_pwd)."' WHERE username='$user[username]'");
		$msg="New password has been saved";
	}
	else {
		$msg="There was an error changing the password";
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_user&id=$user[userid]&msg=$msg&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}

if($action == "edit_pin") {
	if($new_pin != "") {
		$sql=$Db1->query("UPDATE user SET pin='".md5($new_pin)."' WHERE username='$user[username]'");
		$msg="New pin has been saved";
	}
	else {
		$msg="There was an error changing the pin";
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_user&id=$user[userid]&msg=$msg&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}

if($action == "shiftDL") {
	if(count($select) != 0) {
		for($x=0; $x<count($select); $x++) {
			$usrname=assign($select[$x], $user[username], $touser);
			$thelistr.="<li>$usrname";
		}
		$msg="The following referrals were shifted to the account: $touser<br /><br />$thelistr";
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=edit_user&id=$user[userid]&msg=$msg;direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
		exit;
	}
}


if($action == "editm") {
	if($mtype == "basic") {
		$Db1->query("UPDATE user SET type='0', membership='0' WHERE username='$userinfo[username]'");
	}
	else {
		$sql=$Db1->query("SELECT * FROM memberships WHERE id='$mtype'");
		$membership=$Db1->fetch_array($sql);
		if($joinbenefits == 1) {
			$sql=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$mtype' and time_type='U'");
			while($benefit = $Db1->fetch_array($sql)) {
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

		if(($user[pend] < time()) || ($user[membership] != $order[premium_id])) {
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
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_user&id=$user[userid]&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	exit;
}


if($action == "edit") {
	$sql=$Db1->query("UPDATE user SET
	username='$uname',
	name='$name',
	country='$country',
	refered='$refered',
	referrals1='$referrals1',
	referrals2='$referrals2',
	referrals3='$referrals3',
	referrals4='$referrals4',
	referrals5='$referrals5',
	permission='$permission1',
	popup_credits='$popup_credits',
	suspended='$suspended',
	balance='$balance',
	ptsu_credits='$ptsu_credits',
	email='$email',
	tickets='$tickets',
	`group`='$mgroup',
	referral_earns='$referral_earns',
	points='$points',
	link_credits='$link_credits',
	fad_credits='$fad_credits',
	banner_credits='$banner_credits',
	fbanner_credits='$fbanner_credits',
	ptr_credits='$ptr_credits',
	ptra_credits='$ptra_credits',
	optin='$optin',
        moptin='$moptin',
        confirm='$confirm',
	suspendTime='".(($suspendTime==-1)?"-1":( ($suspendTime*24*60*60) +time()) )."',
	suspendMsg='".htmlentities($suspendMsg)."',
	notes='$notes',
	verified='$verified',
	xcredits='$xcredits'

	WHERE userid='$id'
	");
	$Db1->sql_close();
//	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
	header("Location: admin.php?view=admin&ac=edit_user&id=$user[userid]&msg=The changes have been saved.&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}


if($userinfo[pstart] == "") {
	$userinfo[pstart]=time();
}

if($userinfo[pend] == "") {
	$userinfo[pend]=time()+2592000;
}



$sql=$Db1->query("SELECT * FROM memberships ORDER BY title");
while($temp=$Db1->fetch_array($sql)) {
	$membershipp[$temp[id]]=$temp[title]." (".
								iif($temp[time_type]=="D","Day").
								iif($temp[time_type]=="W","Week").
								iif($temp[time_type]=="M","Month").
								iif($temp[time_type]=="Y","Year").
								iif($temp[time_type]=="L","Lifetime").
							")";
	$memberlist.="<option value=\"$temp[id]\"".iif(($userinfo[membership]==$temp[id]) && ($userinfo[type]==1)," selected=\"selected\"").">$temp[title] (".
								iif($temp[time_type]=="D","Day").
								iif($temp[time_type]=="W","Week").
								iif($temp[time_type]=="M","Month").
								iif($temp[time_type]=="Y","Year").
								iif($temp[time_type]=="L","Lifetime").
							")\n";
}


$sql=$Db1->query("SELECT * FROM sessions WHERE user_id='$id' LIMIT 1");
$isonline=$Db1->num_rows();


$sql=$Db1->query("SELECT footprints.* FROM footprints WHERE username='$user[username]' ORDER BY dsub DESC LIMIT 10");
$total_footprints=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_footprints=$Db1->fetch_array($sql); $x++) {
		$footprintsslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td NOWRAP=\"NOWRAP\" style=\"padding: 0 20 0 0\">".date('g:i A - M d, Y', @mktime(0,0,$this_footprints[dsub],1,1,1970))."</td>
					<td NOWRAP=\"NOWRAP\" style=\"padding: 0 20 0 0\"><a title=\"$this_footprints[uri]\">$this_footprints[title]</a></td>
				</tr>
";
	}
}
else {
	$footprintsslisted="
		<tr>
			<td class=\"tableHL2\" colspan=10 align=\"center\">No Footprints Found!</td>
		</tr>";
}


$sql=$Db1->query("SELECT logs.* FROM logs WHERE username='$user[username]' ORDER BY dsub DESC LIMIT 10");
$total_footprints=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_logs=$Db1->fetch_array($sql); $x++) {
		$logslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td NOWRAP=\"NOWRAP\"><div  style=\"padding: 0 10 0 5px;\">".date('M d, Y', @mktime(0,0,$this_logs[dsub],1,1,1970))."</div></td>
					<td NOWRAP=\"NOWRAP\"><div  style=\"padding: 0 5 0 10px;\">".iif($this_logs[order_id]!="","<a href=\"admin.php?view=admin&ac=ledger&search=1&search_str=$this_logs[order_id]&search_by=payment_id&".$url_variables."\">")."$this_logs[log]</a></div></td>
				</tr>
";
	}
}
else {
	$logslisted="
		<tr>
			<td class=\"tableHL2\" colspan=10 align=\"center\">No Logs Found!</td>
		</tr>";
}


$sql=$Db1->query("SELECT * FROM member_groups ORDER BY title");
while($temp=$Db1->fetch_array($sql)) {
	$grouplist.="<option value=\"$temp[id]\" ".iif($userinfo[group] == $temp[id], "selected=\"selected\"").">$temp[title]";
}

$includes[content]="
<script>
function supdate(section,close) {

	document.getElementById('edit_user').style.display='none'
	document.getElementById('footprints').style.display='none'
	document.getElementById('edit_membership').style.display='none'
	document.getElementById('overview').style.display='none'
	document.getElementById('payments').style.display='none'
	document.getElementById('orders').style.display='none'
	document.getElementById('ads').style.display='none'
	document.getElementById('downline').style.display='none'
	document.getElementById('logs').style.display='none'
	document.getElementById('delete').style.display='none'
	document.getElementById('pwd').style.display='none'
        document.getElementById('pin').style.display='none'

	document.getElementById(section).style.display='';

	if(close == 1) document.getElementById(section).style.display='none';
}
</script>
<div align=\"left\">
<table cellpadding=0 cellspacing=0>
	<tr>
		<td><a href=\"javascript:supdate('edit_user',0)\"><img src=\"images/edit_user.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('edit_user',0)\">&nbsp;<b>Edit User</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('ads',0)\"><img src=\"images/ads.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('ads',0)\">&nbsp;<b>User's Ads</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('edit_membership',0)\"><img src=\"images/member_membership.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('edit_membership',0)\">&nbsp;<b>Membership</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('overview',0)\"><img src=\"images/member_overview.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('overview',0)\">&nbsp;<b>Overview</a></td>

	</tr>
	<tr>
		<td><a href=\"javascript:supdate('payments',0)\"><img src=\"images/payment_history.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('payments',0)\">&nbsp;<b>Payments</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('orders',0)\"><img src=\"images/orders.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('orders',0)\">&nbsp;<b>Order Ledger</a></td>

		<td width=20></td>
		<td><a href=\"javascript:supdate('logs',0)\"><img src=\"images/logs.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('logs',0)\">&nbsp;<b>Activity Logs</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('footprints',0)\"><img src=\"images/footprints.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('footprints',0)\">&nbsp;<b>Foot Prints</a></td>


	</tr>
	<tr>


		<td><a href=\"javascript:supdate('downline',0)\"><img src=\"images/downline.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('downline',0)\">&nbsp;<b>Downline</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('pwd',0)\"><img src=\"images/pwd.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('pwd',0)\">&nbsp;<b>Password</a></td>
                <td width=20></td>

		<td><a href=\"javascript:supdate('delete',0)\"><img src=\"images/delete.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('delete',0)\">&nbsp;<b>Delete</a></td>

		<td width=20></td>

		<td><a href=\"javascript:supdate('pin',0)\"><img src=\"images/pwd.gif\" border=0></a></td>
		<td><a href=\"javascript:supdate('pin',0)\">&nbsp;<b>Change PIN</a></td>
		<td width=20></td>


	</tr>
         <tr>
		<td><a href=\"javascript:supdate('warn',0)\"><img src=\"images/warnings.png\" border=0></a></td>
		<td><a href=\"javascript:supdate('warn',0)\">&nbsp;<b>Issue Warning</a></td>

		<td width=20></td>

	</tr>
</table>
<br />

<!--  ##########################################################################################################################################################-->
<div id=\"footprints\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Recent Footprints <a href=\"javascript:supdate('footprints',1)\" style=\"color: red\">X</a></b>
<div align=\"right\"><a href=\"admin.php?view=admin&ac=footprints&search=1&search_str=$user[username]&search_by=username&".$url_variables."\">View All Footprints</a></div>
<div style=\" width: 100%; overflow: auto;\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100%\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td NOWRAP><b>Date</b></td>
					<td NOWRAP><b>Title</b></td>
				</tr>

					$footprintsslisted

			</table>
		</td>
	</tr>
</table><br />
</div>
</div>

<!--  ##########################################################################################################################################################-->
<div id=\"edit_user\" style=\"display: none;\">
<form action=\"admin.php?view=admin&ac=edit_user&action=edit&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\" name=\"edit_user\">
<b style=\"font-size: 20px;\">Edit User <a href=\"javascript:supdate('edit_user',1)\" style=\"color: red\">X</a></b><br />


<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Primary Information</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Username:</td>
					<td><input type=\"text\" value=\"$userinfo[username]\" name=\"uname\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Name:</td>
					<td><input type=\"text\" value=\"$userinfo[name]\" name=\"name\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Country:</td>
					<td><input type=\"text\" value=\"$userinfo[country]\" name=\"country\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap colspan=2>Password Hash: &nbsp;&nbsp;&nbsp;<small style=\"color: darkblue\">$userinfo[password]</small></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap width=\"200\">Email:</td>
					<td><input type=\"text\" value=\"$userinfo[email]\" name=\"email\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Email Verified?</td>
					<td>
						<select name=\"verified\">
							<option value=\"0\" ".iif($userinfo[verified]=="0"," selected").">No
							<option value=\"1\" ".iif($userinfo[verified]=="1"," selected").">Yes
						</select>
					</td>
				</tr>
	<tr class=\"tableHL2\">
					<td>Admin Mailer Opt In?</td>
					<td>
						<select name=\"moptin\">
							<option value=\"0\" ".iif($userinfo[moptin]=="0"," selected").">No
							<option value=\"1\" ".iif($userinfo[moptin]=="1"," selected").">Yes
						</select>
					</td>
				</tr>

	<tr class=\"tableHL2\">
					<td>Approve access $thisuserinfo[confirm]</td>
					<td>
						<select name=\"confirm\">
							<option value=\"0\" ".iif($userinfo[confirm]=="0"," selected").">No
							<option value=\"1\" ".iif($userinfo[confirm]=="1"," selected").">Yes
						</select>
					</td>
				</tr>


".iif(SETTING_PTR == true,"
				<tr class=\"tableHL2\">
					<td>Opt In?</td>
					<td>
						<select name=\"optin\">
							<option value=\"0\" ".iif($userinfo[optin]=="0"," selected").">No
							<option value=\"1\" ".iif($userinfo[optin]=="1"," selected").">Yes
						</select>
					</td>
				</tr>")."
				<tr class=\"tableHL2\">
					<td>Suspended?</td>
					<td>
						<select name=\"suspended\">
							<option value=\"0\" ".iif($userinfo[suspended]=="0"," selected").">No
							<option value=\"1\" ".iif($userinfo[suspended]=="1"," selected").">Yes
						</select>
					</td>
				</tr>

				<tr class=\"tableHL2\">
					<td nowrap width=\"200\">Suspend Time?:</td>
					<td><input type=\"text\" value=\"".iif($userinfo['suspendTime']==-1,"-1", iif($userinfo['suspendTime']=="","",  (($userinfo['suspendTime']-time())/60/60/24)  )  )."\" name=\"suspendTime\" size=3> <small>Days (-1 forever)</small></td>
				</tr>

				<tr class=\"tableHL2\">
					<td nowrap width=\"200\">Suspend Message:</td>
					<td><input type=\"text\" value=\"".$userinfo['suspendMsg']."\" name=\"suspendMsg\"></td>
				</tr>

				<tr class=\"tableHL2\">
					<td>Group</td>
					<td>
						<select name=\"mgroup\">
							<option value=\"\">
							$grouplist
						</select>
					</td>
				</tr>

				<tr class=\"tableHL2\">
					<td>Permission:</td>
					<td>
						<select name=\"permission1\" onchange=\"update_mod()\">
							<option value=\"0\" ".iif($userinfo[permission]=="0"," selected").">Member
							<option value=\"7\" ".iif($userinfo[permission]=="7"," selected").">Admin
						</select>
					</td>
				</tr>


				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Account Balances</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Balance:</td>
					<td><input type=\"text\" value=\"$userinfo[balance]\" name=\"balance\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Points:</td>
					<td><input type=\"text\" value=\"$userinfo[points]\" name=\"points\"></td>
				</tr>".iif(SETTING_PTC==true,"
				<tr class=\"tableHL2\">
					<td>Link Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[link_credits]\" name=\"link_credits\"></td>
				</tr>")."".iif(SETTING_PTSU==true,"
				<tr class=\"tableHL2\">
					<td>PTSU Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[ptsu_credits]\" name=\"ptsu_credits\"></td>
				</tr>")."".iif(SETTING_PTR==true,"
				<tr class=\"tableHL2\">
					<td>Email Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[ptr_credits]\" name=\"ptr_credits\"></td>
				</tr>")."".iif(SETTING_PTRA==true,"
				<tr class=\"tableHL2\">
					<td>PTR Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[ptra_credits]\" name=\"ptra_credits\"></td>
				</tr>")."".iif(SETTING_PTP==true,"
				<tr class=\"tableHL2\">
					<td>Popup Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[popup_credits]\" name=\"popup_credits\"></td>
				</tr>")."".iif(SETTING_CE==true,"
				<tr class=\"tableHL2\">
					<td>X-Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[xcredits]\" name=\"xcredits\"></td>
				</tr>")."
				<tr class=\"tableHL2\">
					<td>Banner Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[banner_credits]\" name=\"banner_credits\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Featured Banner Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[fbanner_credits]\" name=\"fbanner_credits\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>F.Ad Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[fad_credits]\" name=\"fad_credits\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Tickets:</td>
					<td><input type=\"text\" value=\"$userinfo[tickets]\" name=\"tickets\"></td>
				</tr>
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Downline Information</td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Referrer:</td>
					<td><input type=\"text\" value=\"$userinfo[refered]\" name=\"refered\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Ref Earns:</td>
					<td><input type=\"text\" value=\"$userinfo[referral_earns]\" name=\"referral_earns\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Level 1 Referrals:</td>
					<td><input type=\"text\" value=\"$userinfo[referrals1]\" name=\"referrals1\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Level 2 Referrals:</td>
					<td><input type=\"text\" value=\"$userinfo[referrals2]\" name=\"referrals2\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Level 3 Referrals:</td>
					<td><input type=\"text\" value=\"$userinfo[referrals3]\" name=\"referrals3\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Level 4 Referrals:</td>
					<td><input type=\"text\" value=\"$userinfo[referrals4]\" name=\"referrals4\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>Level 5 Referrals:</td>
					<td><input type=\"text\" value=\"$userinfo[referrals5]\" name=\"referrals5\"></td>
				</tr>

				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Notes</td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\"><textarea name=\"notes\" rows=5 cols=37>$userinfo[notes]</textarea></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Save Changes\">
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form><br />
</div>

<!--  ##########################################################################################################################################################-->
<div id=\"edit_membership\" style=\"display: none;\">
<form action=\"admin.php?view=admin&ac=edit_user&id=$id&action=editm&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<b style=\"font-size: 20px;\">Edit Membership <a href=\"javascript:supdate('edit_membership',1)\" style=\"color: red\">X</a></b><br />
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Membership</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Membership:</td>
					<td>".iif($userinfo[type]==0,"Basic",$membershipp[$userinfo[membership]])."</td>
				</tr>".iif($userinfo[type]==1,"
				<tr class=\"tableHL2\">
					<td>Ends In:</td>
					<td>".floor(($userinfo[pend]-time())/24/60/60)." Days</td>
				</tr>")."
				<tr class=\"tableHL2\">
					<td>Set Membership:</td>
					<td>
					<select name=\"mtype\">
						<option value=\"basic\">Basic
						$memberlist
					</select></td>
				</tr>
				<tr class=\"tableHL2\">
					<td nowrap>For:</td>
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
</form><br />
</div>
<!--  ##########################################################################################################################################################-->
<div id=\"overview\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Member Overview <a href=\"javascript:supdate('overview',1)\" style=\"color: red\">X</a></b><br />
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"500\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Member Overview</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Status:</td>
					<td>".iif($isonline==1,"<img src=\"admin2/includes/icons/user.gif\"><font color=\"darkgreen\"><b>Online</b></a>","<img src=\"admin2/includes/icons/user_off.gif\"><font color=\"darkred\">Offline</a>")."</td>
				</tr>
				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Country:</td>
					<td>$userinfo[country]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Sex:</td>
					<td>$userinfo[sex]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Birth Year:</td>
					<td>$userinfo[birth]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Joined:</td>
					<td>".date('M d, Y', @mktime(0,0,$userinfo[joined],1,1,1970))."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Last Activity:</td>
					<td>".date('M d, Y', @mktime(0,0,$userinfo[last_act],1,1,1970))."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Last IP:</td>
					<td>$userinfo[last_ip]</td>
				</tr>

				<tr class=\"tableHL2\">
					<td nowrap>Password Hash:</td>
					<td><small style=\"color: darkblue\">$userinfo[password]</small></td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>

				<tr class=\"tableHL2\">
					<td>Failed Logins:</td>
					<td>$userinfo[failed_logins]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>FloodGuard Activations:</td>
					<td>$userinfo[floodguard]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>FloodGuard Activations Today:</td>
					<td>$userinfo[floodguard_today]</td>
				</tr>




				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Raw Referral Hits:</td>
					<td>$userinfo[ref_hits_raw]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Unique Referral Hits:</td>
					<td>$userinfo[ref_hits_unique]</td>
				</tr>


				".iif(SETTING_PTSU==true,"
					<tr style=\"background-color: white;\">
						<td height=5></td>
						<td></td>
					</tr>
					<tr class=\"tableHL2\">
						<td>Approved Signups: </td>
						<td>$userinfo[ptsu_approved]</td>
					</tr>
					<tr class=\"tableHL2\">
						<td>Denied Signups: </td>
						<td>$userinfo[ptsu_denied]</td>
					</tr>
					<tr class=\"tableHL2\">
						<td>PTSU Earnings: </td>
						<td>$userinfo[ptsu_earnings]</td>
					</tr>

				")."

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Link Clicks:</td>
					<td>$userinfo[clicks]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Link Clicks Today:</td>
					<td>$userinfo[clicked_today]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Last Link Click:</td>
					<td>".date('M d, Y', @mktime(0,0,$userinfo[last_click],1,1,1970))."</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTP Hits:</td>
					<td>$userinfo[ptphits]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTP Hits Today:</td>
					<td>$userinfo[ptphits_today]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTP Earnings:</td>
					<td>$userinfo[ptpearns]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Signup Score: ".show_help("PTP Signup Score - This number helps find ptp cheaters. The number represents how many ptp hits were paid per 1 signups. The higher this number is, the higher the chance that they are using an emulator. ")."</td>
					<td>".iif($userinfo[ptphits] > 0, @number_format(round($userinfo[ptphits]/($userinfo[referrals1]>0?$userinfo[referrals1]:1))), "0")."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Referrals (lvl 1):</td>
					<td>$userinfo[referrals1]</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Email Clicks:</td>
					<td>$userinfo[emails]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Email Clicks Today:</td>
					<td>$userinfo[emails_today]</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTRA Clicks:</td>
					<td>$userinfo[ptra_clicks]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTRA Clicks Today:</td>
					<td>$userinfo[ptra_clicks_today]</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Exchange Clicks:</td>
					<td>$userinfo[xclicks]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Exchange Clicks Today:</td>
					<td>$userinfo[xclicked_today]</td>
				</tr>


			</table>
		</td>
	</tr>
</table>
<br />
</div>";


$sql=$Db1->query("SELECT requests.*, withdraw_options.title FROM requests, withdraw_options WHERE requests.username='$user[username]' and withdraw_options.id=requests.accounttype ORDER BY requests.dsub DESC");
if($Db1->num_rows() != 0) {
	while($temp=$Db1->fetch_array($sql)) {
		$pendinglist.="
		<tr>
			<td>".date('M d, Y', @mktime(0,0,$temp[dsub],1,1,1970))."</td>
			<td>$temp[title]</td>
			<td>$temp[account]</td>
			<td>$cursym $temp[fee]</td>
			<td>$cursym $temp[amount]</td>
			<td><a href=\"admin.php?view=admin&ac=requests&action=markpaid&id=$temp[id]&user=$user&".$url_variables."\" onclick=\"return confirm('Are You Sure You Want To Mark This Paid?')\">Mark Paid</a></td>
			<td><a href=\"admin.php?view=admin&ac=requests&action=cancel&id=$temp[id]&user=$user&".$url_variables."\" onclick=\"return confirm('Are You Sure You Want To Cancel This?')\">Cancel</a></td>
			<td><a href=\"admin.php?view=admin&ac=requests&action=delete&id=$temp[id]&user=$user&".$url_variables."\" onclick=\"return confirm('Are You Sure You Want To Delete This?')\">Delete</a></td>
		</tr>
		";
	}
}
else {
	$pendinglist="
		<tr>
			<td align=\"center\" colspan=5><font color=\"#236381\">No Pending Requests</font></td>
		</tr>
	";
}


$sql=$Db1->query("SELECT * FROM payment_history WHERE username='$user[username]' ORDER BY dsub DESC");
if($Db1->num_rows() != 0) {
	while($temp=$Db1->fetch_array($sql)) {
		$historylist.="
		<tr>
			<td>".date('M d, Y', @mktime(0,0,$temp[rdsub],1,1,1970))."</td>
			<td>".iif($temp[status]==1,"".date('M d, Y', @mktime(0,0,$temp[dsub],1,1,1970))."")."".iif($temp[status]==2,"Canceled")."".iif($temp[status]==0,"Queued For Payment")."</td>
			<td>$temp[accounttype]</td>
			<td>$temp[account]</td>
			<td>$cursym $temp[fee]</td>
			<td>$cursym $temp[amount]</td>
		</tr>
		";
	}
}
else {
	$historylist="
		<tr>
			<td align=\"center\" colspan=4><font color=\"#236381\">No Withdraw History</font></td>
		</tr>
	";
}

$includes[content].="
<!--  ##########################################################################################################################################################-->
<div id=\"payments\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Payment History <a href=\"javascript:supdate('payments',1)\" style=\"color: red\">X</a></b><br />
<br />
<div align=\"center\"><b>Pending Requests</b></div>
<table width=\"100%\">
	<tr>
		<td><b>Request Date</b></td>
		<td><b>Method</b></td>
		<td><b>Account</b></td>
		<td><b>Fee</b></td>
		<td><b>Net</b></td>
		<td><b></b></td>
	</tr>
	$pendinglist
</table>

<br /><br />
<div align=\"center\"><b>Withdraw History</b></div>

<table width=\"100%\">
	<tr>
		<td><b>Request Date</b></td>
		<td><b>Date Paid</b></td>
		<td><b>Method</b></td>
		<td><b>Account</b></td>
		<td><b>Fee</b></td>
		<td><b>Net</b></td>
	</tr>
	$historylist
</table>
<br />
</div>

";

$sql=$Db1->query("SELECT ledger.* FROM ledger WHERE username='$user[username]' ORDER BY dsub DESC");
$total_ledger=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_ledger=$Db1->fetch_array($sql); $x++) {
		$ledgerslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td NOWRAP=\"NOWRAP\">".date('M d, Y', @mktime(0,0,$this_ledger[dsub],1,1,1970))."</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[product]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[amount]</td>
					<td NOWRAP=\"NOWRAP\">$cursym $this_ledger[cost]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[proc]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[account]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[transaction_id]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[payment_id]</td>
				</tr>
";
	}
}
else {
	$ledgerslisted="
		<tr>
			<td class=\"tableHL2\" colspan=9 align=\"center\">No Search Results Found!</td>
		</tr>";
}

$includes[content].="
<!--  ##########################################################################################################################################################-->
<div id=\"orders\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Order Ledger <a href=\"javascript:supdate('orders',1)\" style=\"color: red\">X</a></b><br />
<div style=\" width: 100%; overflow: auto;\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"1000\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td NOWRAP><b>Date</b></a></td>
					<td NOWRAP><b>Product</b></a></td>
					<td NOWRAP><b>Amount</b></a></td>
					<td NOWRAP><b>Price</b></a></td>
					<td NOWRAP><b>Method</b></a></td>
					<td NOWRAP><b>Account</b></a></td>
					<td NOWRAP><b>Transaction Id</b></a></td>
					<td NOWRAP><b>Order Id</b></td>
				</tr>

					$ledgerslisted

			</table>
		</td>
	</tr>
</table>
<br />
</div>
</div>

";

if(SETTING_PTC == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM ads WHERE username='$user[username]'");
	$adstotal['links']=$Db1->fetch_array($sql);
}
if(SETTING_PTR == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM emails WHERE username='$user[username]'");
	$adstotal['emails']=$Db1->fetch_array($sql);
}
if(SETTING_PTRA == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM ptrads WHERE username='$user[username]'");
	$adstotal['ptrads']=$Db1->fetch_array($sql);
}
if(SETTING_PTP == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM popups WHERE username='$user[username]'");
	$adstotal['popups']=$Db1->fetch_array($sql);
}
if(SETTING_CE == true) {
	$sql = $Db1->query("SELECT COUNT(id) AS total FROM xsites WHERE username='$user[username]'");
	$adstotal['xsites']=$Db1->fetch_array($sql);
}


$sql = $Db1->query("SELECT COUNT(id) AS total FROM banners WHERE username='$user[username]'");
$adstotal['banners']=$Db1->fetch_array($sql);

$sql = $Db1->query("SELECT COUNT(id) AS total FROM fbanners WHERE username='$user[username]'");
$adstotal['fbanners']=$Db1->fetch_array($sql);

$sql = $Db1->query("SELECT COUNT(id) AS total FROM flinks WHERE username='$user[username]'");
$adstotal['flinks']=$Db1->fetch_array($sql);

$sql = $Db1->query("SELECT COUNT(id) AS total FROM fads WHERE username='$user[username]'");
$adstotal['fads']=$Db1->fetch_array($sql);



$includes[content].="

<!--  ##########################################################################################################################################################-->
<div id=\"ads\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">User's Ads <a href=\"javascript:supdate('ads',1)\" style=\"color: red\">X</a></b><br />

<table>
<tr><td valign=\"top\">

<table width=200>
".iif(SETTING_PTC == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=links&search=1&search_str=$user[username]&search_by=username\">Paid Link Ads</a></td>
		<td>".$adstotal[links][total]."</td>
	</tr>
")."
".iif(SETTING_PTR == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=emails&search=1&search_str=$user[username]&search_by=username\">Email Ads</a></td>
		<td>".$adstotal[emails][total]."</td>
	</tr>
")."
".iif(SETTING_PTRA == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=ptrads&search=1&search_str=$user[username]&search_by=username\">PTR Ads</a></td>
		<td>".$adstotal[ptrads][total]."</td>
	</tr>
")."
".iif(SETTING_PTP == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=popups&search=1&search_str=$user[username]&search_by=username\">Popups</a></td>
		<td>".$adstotal[popups][total]."</td>
	</tr>
")."

</table>
</td>

<td width=20></td>

<td valign=\"top\">
<table width=200>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=banners&search=1&search_str=$user[username]&search_by=username\">Banners</a></td>
		<td>".$adstotal[banners][total]."</td>
	</tr>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=fbanners&search=1&search_str=$user[username]&search_by=username\">Featured Banners</a></td>
		<td>".$adstotal[fbanners][total]."</td>
	</tr>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=fads&search=1&search_str=$user[username]&search_by=username\">Featured Ads</a></td>
		<td>".$adstotal[fads][total]."</td>
	</tr>
	<tr>
		<td><a href=\"admin.php?view=admin&ac=flinks&search=1&search_str=$user[username]&search_by=username\">Featured Links</a></td>
		<td>".$adstotal[flinks][total]."</td>
	</tr>
".iif(SETTING_CE == true,"
	<tr>
		<td><a href=\"admin.php?view=admin&ac=xsites&search=1&search_str=$user[username]&search_by=username\">Exchange Sites</a></td>
		<td>".$adstotal[xsites][total]."</td>
	</tr>
")."
</table>

</td></tr></table>


<br />
</div>





<!--  ##########################################################################################################################################################-->
<div id=\"pwd\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Change Password <a href=\"javascript:supdate('pwd',1)\" style=\"color: red\">X</a></b><br />
	<form action=\"admin.php?view=admin&ac=edit_user&action=edit_pwd&id=$id&".$url_variables."\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to change this user\'s password?')\">
		New Password: <input type=\"text\" name=\"new_pwd\" value=\"\">
		<input type=\"submit\" value=\"Change Password\">
	</form>
</div>




<!--  ##########################################################################################################################################################-->
<div id=\"delete\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Delete User <a href=\"javascript:supdate('delete',1)\" style=\"color: red\">X</a></b><br />
	<form action=\"admin.php?view=admin&ac=delete_user&step=2&id=$id&do=delete&direct=members&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to delete this member?')\">
		<input type=\"hidden\"  name=\"action\" value=\"Delete\">
		<input type=\"submit\" value=\"Click Here To Delete This Member\">
	</form>
</div>

<!--  ##########################################################################################################################################################-->
<div id=\"pin\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Change Pin <a href=\"javascript:supdate('pin',1)\" style=\"color: red\">X</a></b><br />
	<form action=\"admin.php?view=admin&ac=edit_user&action=edit_pin&id=$id&".$url_variables."\" method=\"POST\" onsubmit=\"return confirm('Are you sure you want to change this user\'s pin?')\">
		New Pin: <input type=\"text\" name=\"new_pin\" value=\"\">
		<input type=\"submit\" value=\"Change Pin\">
	</form>
</div>

<!--  ##########################################################################################################################################################-->
<div id=\"warn\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Warn User <a href=\"javascript:supdate('warn',1)\" style=\"color: red\">X</a></b><br />
<form method=\"post\" action=admin.php?view=admin&ac=givewarnings&action=add&".$url_variables."\">
<table>
        <tr>
                <td>Username</td>
                <td><input type=\"text\" value=\"$userinfo[username]\" name=\"username3\"></td>
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
                <td><font color=\"darkgreen\">You can change this on the Member Settings page</font></td>
        </tr>

</table>

	</form>
</div>

<!--  ##########################################################################################################################################################-->
<div id=\"logs\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Activity Logs <a href=\"javascript:supdate('logs',1)\" style=\"color: red\">X</a></b><br />
<div align=\"right\"><a href=\"admin.php?view=admin&ac=logs&search=1&search_str=$user[username]&search_by=username&".$url_variables."\">View All Logs</a></div>
<div style=\" width: 100%; overflow: auto;\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td NOWRAP><div  style=\"padding: 0 5 0 5px;\"><a href=\"admin.php?view=admin&ac=logs&".$url_variables."\"><b>Date</b> ".$order['logs.dsub']."</a></div></td>
					<td NOWRAP><div  style=\"padding: 0 5 0 5px;\"><a href=\"admin.php?view=admin&ac=logs&".$url_variables."\"><b>Log</b> ".$order['logs.log']."</a></div></td>
				</tr>

					$logslisted

			</table>
		</td>
	</tr>
</table>
</div>
</div>





<!--  ##########################################################################################################################################################-->
<div id=\"downline\" style=\"display: none;\"><br />
<b style=\"font-size: 20px;\">Downline Stats <a href=\"javascript:supdate('downline',1)\" style=\"color: red\">X</a></b><br />
";

$sql=$Db1->query("SELECT * FROM user WHERE refered='$user[username]' ORDER BY last_act DESC");
if($Db1->num_rows() != 0) {
	for($x=0; $dluser=$Db1->fetch_array($sql); $x++) {
		$totals[level1]++;
		$totals[level2]+=$dluser[referrals1];
		$totals[level3]+=$dluser[referrals2];
		$totals[level4]+=$dluser[referrals3];
		$totals[level5]+=$dluser[referrals4];

		$downline.="
				<tr class=\"tableHL2\">
					<td>
						<input type=\"checkbox\" value=\"$dluser[userid]\" name=\"select[]\">
					</td>
					<td>$dluser[username]</td>
					<td align=\"center\">$dluser[referrals1]</td>
					<td align=\"center\">$dluser[referrals2]</td>
					<td align=\"center\">$dluser[referrals3]</td>
					<td align=\"center\">$dluser[referrals4]</td>
					<td align=\"center\">".iif($dluser[last_act]!="", date('l, F j Y', @mktime(0,0,$dluser[last_act],1,1,1970)), "")."</td><td align=\"center\">
					".iif($user[refstat] == 0,"<strong title=\"Referred Referral\">Reffered</strong>")."
					".iif($user[refstat] == 1,"<strong title=\"Purchased Referral\">Purchased</strong>")."
					".iif($user[refstat] == 2,"<strong title=\"Shifted Referral\">Shifted</strong>")."
					".iif($user[refstat] == 3,"<strong title=\"Admin Assigned Referral\">Admin</strong>")."
</td><td align=\"center\">$dluser[last_ip]</td>
				</tr>
		";
	}
	$includes[content].="
<SCRIPT LANGUAGE=\"JavaScript\">

//Base code inspired by hotmail.com - modified by Scott Klarr - admin@illusive-web.com
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
<form  name=\"frm\" action=\"admin.php?view=admin&ac=edit_user&action=shiftDL&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\" onsubmit=\"return validate2()\">
			<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td><input type=\"checkbox\" value=\"1\" name=\"allbox\" onClick=\"CA()\"></td>
					<td><b>Level 1</b></td>
					<td align=\"center\"><b>2</b></td>
					<td align=\"center\"><b>3</b></td>
					<td align=\"center\"><b>4</b></td>
					<td align=\"center\"><b>5</b></td>
					<td align=\"center\"><b>Last Activity</b></td><td align=\"center\"><b>Status</b></td><td><b>Ip Address</b></td>
				</tr>
				$downline

				<tr class=\"tableHL1\">
					<td align=\"center\" colspan=7><b>Totals</b></td>
				</tr>

				<tr class=\"tableHL2\">
					<td></td>
					<td>$totals[level1]</td>
					<td align=\"center\">$totals[level2]</td>
					<td align=\"center\">$totals[level3]</td>
					<td align=\"center\">$totals[level4]</td>
					<td align=\"center\">$totals[level5]</td>
					<td align=\"center\"></td>
				</tr>
			</table>
<br />
<div align=\"left\">
Shift Checked Referrals To Account: <input type=\"text\" name=\"touser\" value=\"\"><input type=\"submit\" value=\"Shift Referrals\">
</div>
</form>
";
}
else {
	$includes[content].="
This member does not have any referrals.
";
}


$includes[content].="
</div>


</div>

".iif($msg!="","<br /><br /><font color=\"red\">The following message was generated:</font><br />$msg")."

";
}
//**E**//

?>
