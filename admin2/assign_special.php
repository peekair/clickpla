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
$includes[title]="Assign Ad Special";



function bought_special($id, $user, $qty) {
	global $Db1, $headers, $settings, $username;
	$sql=$Db1->query("SELECT * FROM specials WHERE id='$id'");
	$special=$Db1->fetch_array($sql);
	$sql=$Db1->query("SELECT * FROM special_benefits WHERE special='$id'");
		while($benefit = $Db1->fetch_array($sql)) {
			if($benefit[type] != "") {
				if($benefit[type] == "referrals") {
					$sql2=$Db1->query("SELECT userid FROM user WHERE refered='' and username!='$user'");
					$totalrefsavailable=$Db1->num_rows();
					$refstoassign = $benefit[amount]*$qty;
					if($totalrefsavailable < $refstoassign) {
						$refstoassign=$totalrefsavailable;
						$amounts=1;
					}
					for($x=0; $x<$refstoassign; $x++) {
						assign($user);
					}
				}
				else {
					$sql=$Db1->query("UPDATE user SET $benefit[type]=$benefit[type]+".($benefit[amount]*$qty)." WHERE username='$user'");
				}
			}
		}
	$sql=$Db1->query("INSERT INTO logs SET username='".$user."', log='Admin [$username] Credited [$qty] $special[title] Advertising Special', dsub='".time()."'");
}



function update_upline($username,$referrals1=0,$referrals2=0,$referrals3=0,$referrals4=0,$referrals5=0,$level) {
	global $procs, $Db1, $headers, $settings;
	if($level < 5) {
		$sql=$Db1->query("UPDATE user SET 
			referrals1=referrals1+$referrals1,
			referrals2=referrals2+$referrals2,
			referrals3=referrals3+$referrals3,
			referrals4=referrals4+$referrals4,
			referrals5=referrals5+$referrals5,
			referrals=referrals+".($referrals1+$referrals2+$referrals3+$referrals4+$referrals5)."
			
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
	global $procs, $Db1, $headers, $settings;
	$sql=$Db1->query("SELECT * FROM user WHERE refered='' and username!='$username' ORDER BY last_act DESC LIMIT 1");
	$referral=$Db1->fetch_array($sql);
	$sql=$Db1->query("UPDATE user SET refered='$username' WHERE username='$referral[username]'");

	update_upline($username,1,
		iif($referral['referrals1']=="",0,$referral['referrals1']),
		iif($referral['referrals2']=="",0,$referral['referrals2']),
		iif($referral['referrals3']=="",0,$referral['referrals3']),
		iif($referral['referrals4']=="",0,$referral['referrals4']),
	1);
//	return "Setting $referral[username] In $username's Downline<br />";
}

if($action == "credit") {
	bought_special($special, $user, $qty);
	$includes[content].="<font color=\"red\">User '$user' has been credited with $qty"."x specials.</font><br /><br />";
}

$sql=$Db1->query("SELECT * FROM specials ORDER BY title");
while($temp=$Db1->fetch_array($sql)) {
	$speciallist.="<option value=\"$temp[id]\">$temp[title]";
}

$includes[content].="
This tool allows you to assign an ad special to a member's account.<br /><br />

<form action=\"admin.php?view=admin&ac=assign_special&action=credit&".$url_variables."\" method=\"post\">
Quantity: <input type=\"text\" size=5 value=\"1\" name=\"qty\"><br />
Special: <select name=\"special\">$speciallist</select><br />
Member: <input type=\"text\" name=\"user\" value=\"$user\"><br />
<input type=\"submit\" value=\"Credit Account\">
</form>

";

?>
