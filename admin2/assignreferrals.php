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
$includes[title]="Assign Referrals";
//**S**//
$thePermission=6;
function update_upline($username,$referrals1,$referrals2,$referrals3,$referrals4,$referrals5,$level) {
	global $Db1;
	if($level < 5) {
		$sql=$Db1->query("UPDATE user SET 
			referrals1=referrals1+$referrals1,
			referrals2=referrals2+$referrals2,
			referrals3=referrals3+$referrals3,
			referrals4=referrals4+$referrals4,
			referrals5=referrals5+$referrals5
		WHERE
		username='$username'
		");
		$sql=$Db1->query("SELECT refered FROM user WHERE username='$username'");
		$refered=$Db1->fetch_array($sql);
		if(($refered[refered] != $username)) {
			update_upline($refered[refered],0,$referrals1,$referrals2,$referrals3,$referrals4,($level+1));
		}
	}
}

function assign($username) {
	global $Db1;
	$sql=$Db1->query("SELECT * FROM user WHERE refered='' and username!='$username' ORDER BY rand() DESC LIMIT 1");
	if($Db1->num_rows()!=0) {
		$referral=$Db1->fetch_array($sql);
		$sql=$Db1->query("UPDATE user SET refstat='3', refered='$username' WHERE username='$referral[username]'");
		update_upline($username,1,$referral['referrals1'],$referral['referrals2'],$referral['referrals3'],$referral['referrals4'],1);
	return "Setting $referral[username] In $username's Downline<br />";
	}
	else {
		return "<b>Found No More Referrals Available!</b><br />";
	}
}

if($action == "assign") {
	$sql=$Db1->query("SELECT userid FROM user WHERE username='$uname'");
	if($Db1->num_rows() != 0) {
		for($x=0; $x<$refcount; $x++) {
			$return .= assign($uname);
		}
		$sql=$Db1->query("INSERT INTO logs SET username='".$uname."', log='Admin Assigned $refcount Referrals To Account', dsub='".time()."'");
	}
	else {
		$return = "<b>THE USER $uname DOES NOT EXSIST!</b><br />";
	}
}

$sql=$Db1->query("SELECT userid FROM user WHERE refered=''");
$total=$Db1->num_rows();

$sql=$Db1->query("SELECT userid FROM user WHERE last_act>='".(time()-1296000)."' and refered=''");
$totalactive=$Db1->num_rows();


$sql=$Db1->query("SELECT * FROM user WHERE refered='' ORDER BY referrals1 DESC");
if($Db1->num_rows() != 0) {
	while($user=$Db1->fetch_array($sql)) {
		$totals[level1]++;
		$totals[level2]+=$user[referrals1];
		$totals[level3]+=$user[referrals2];
		$totals[level4]+=$user[referrals3];
		$totals[level5]+=$user[referrals4];

		$downline.="
				<tr>
					<td>$user[username]</td>
					<td align=\"center\">$user[referrals1]</td>
					<td align=\"center\">$user[referrals2]</td>
					<td align=\"center\">$user[referrals3]</td>
					<td align=\"center\">$user[referrals4]</td>
					<td align=\"center\">".iif($user[last_act]!="", date('l, F j Y', mktime(0,0,$user[last_act],1,1,1970)), "")."</td>
				</tr>
		";
	}
	$includes[content]="
			<table class=\"tableData\">
				<tr>
					<th align=\"center\"><b>Level 1</b></th>
					<th align=\"center\"><b>2</b></th>
					<th align=\"center\"><b>3</b></th>
					<th align=\"center\"><b>4</b></th>
					<th align=\"center\"><b>5</b></th>
					<th align=\"center\"><b>Last Activity</b></th>
				</tr>
				$downline
				
				<tr>
					<th align=\"center\" colspan=6><b>Totals</b></th>
				</tr>
				
				<tr>
					<td align=\"center\">$totals[level1]</td>
					<td align=\"center\">$totals[level2]</td>
					<td align=\"center\">$totals[level3]</td>
					<td align=\"center\">$totals[level4]</td>
					<td align=\"center\">$totals[level5]</td>
					<td align=\"center\"></td>
				</tr>
			</table>

";
}


$includes[content]="
$return
$total Referrals<br />$totalactive Active Within Last Two Weeks
<form action=\"admin.php?view=admin&ac=assignreferrals&action=assign&".$url_variables."\" method=\"post\">
Username: <input type=\"text\" name=\"uname\"><br />
Referrals: <input type=\"text\" size=\"3\" name=\"refcount\"><br />
<input type=\"submit\">
</form>

$includes[content]

";
//**E**//
?>
