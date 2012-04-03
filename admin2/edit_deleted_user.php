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
$includes[title]="Edit Deleted Member";
//**S**//

$sql=$Db1->query("SELECT * FROM user_deleted WHERE ".iif($id!="","userid='$id'",iif($uname!="","username='$uname'")));
$userinfo=$Db1->fetch_array($sql);
$user=$userinfo;

if($action == "editm") {
	if($mtype == "basic") {
		$Db1->query("UPDATE user_deleted SET type='0', membership='0' WHERE username='$userinfo[username]'");
	}
	else {
		$sql=$Db1->query("SELECT * FROM memberships WHERE id='$mtype'");
		$membership=$Db1->fetch_array($sql);
		if($joinbenefits == 1) {
			$sql=$Db1->query("SELECT * FROM membership_benefits WHERE membership='$mtype' and time_type='U'");
			while($benefit = $Db1->fetch_array($sql)) {
				if($benefit[type] != "") {
					$sql=$Db1->query("UPDATE user_deleted SET $benefit[type]=$benefit[type]+$benefit[amount] WHERE username='$user[username]'");
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
	
		$sql=$Db1->query("UPDATE user_deleted SET 
			type=1,
			membership='$mtype',
			pend='$pend'
			WHERE username='".$user[username]."'
		");
	}
	$Db1->sql_close();
	$msg="Your changes have been saved.";
//	header("Location: admin.php?view=admin&ac=edit_deleted_user&id=$user[userid]&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
}


if($action == "edit") {
	$sql=$Db1->query("UPDATE user_deleted SET 
	username='$uname',
	name='$name',
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
	email='$email',
	tickets='$tickets',
	referral_earns='referral_earns',
	password='$password',
	points='$points',
	link_credits='$link_credits',
	fad_credits='$fad_credits',
	banner_credits='$banner_credits',
	fbanner_credits='$fbanner_credits',
	ptr_credits='$ptr_credits',
	optin='$optin',
	notes='$notes',
	verified='$verified',
	game_points='$game_points'

	WHERE userid='$id'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."");
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

	
$includes[content]="
$msg<br />
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_deleted_user&id=$id&action=edit&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."\" method=\"post\">
<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">$userinfo[username]</td>
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
					<td nowrap>Password:</td>
					<td><input type=\"text\" value=\"$userinfo[password]\" name=\"password\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Balance:</td>
					<td><input type=\"text\" value=\"$userinfo[balance]\" name=\"balance\"></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Points:</td>
					<td><input type=\"text\" value=\"$userinfo[points]\" name=\"points\"></td>
				</tr>".iif(SETTING_PTP==true,"
				<tr class=\"tableHL2\">
					<td>Game Points:</td>
					<td><input type=\"text\" value=\"$userinfo[game_points]\" name=\"game_points\"></td>
				</tr>")."
				<tr class=\"tableHL2\">
					<td>Link Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[link_credits]\" name=\"link_credits\"></td>
				</tr>".iif(SETTING_PTP==true,"
				<tr class=\"tableHL2\">
					<td>Popup Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[popup_credits]\" name=\"popup_credits\"></td>
				</tr>")."".iif(SETTING_PTR==true,"
				<tr class=\"tableHL2\">
					<td>Email Credits:</td>
					<td><input type=\"text\" value=\"$userinfo[ptr_credits]\" name=\"ptr_credits\"></td>
				</tr>
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
				<tr class=\"tableHL2\">
					<td>Permission:</td>
					<td>
						<select name=\"permission1\">
							<option value=\"0\" ".iif($userinfo[permission]=="0"," selected").">Member
							<option value=\"7\" ".iif($userinfo[permission]=="7"," selected").">Admin
						</select>
					</td>
				</tr>
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
					<td nowrap>Notes:</td>
					<td><textarea name=\"notes\" rows=5>$userinfo[notes]</textarea></td>
				</tr>
				<tr class=\"tableHL2\">
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Edit User\">
						".iif($permission==7,"<input type=\"button\" value=\"Undelete User\" onclick=\"location.href='admin.php?view=admin&ac=undelete_user&id=$id&direct=$direct&start=$start&type=$type&orderby=$orderby&".iif($search==1,"search=1&search_str=$search_str&search_by=$search_by&")."".$url_variables."'\">")."
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>

<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"300\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Deleted Info</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Deleted On:</td>
					<td>".date('M d, Y', mktime(0,0,$userinfo[last_act],1,1,1970))."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Deleted By:</td>
					<td>$userinfo[last_ip]</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br />
</div>
";
//**E**//

?>
