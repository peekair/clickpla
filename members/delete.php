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
$includes[title]="Delete Account";
//**S**//
function edit_upline($x, $ref) {
	global $username, $Db1;
	if($x <= 5) {
		if($username != $ref) {
			$sql=$Db1->query("SELECT * FROM user WHERE username='$ref'");
			$thisuser=$Db1->fetch_array($sql);
			$sql=$Db1->query("UPDATE user SET referrals".($x)."=referrals".($x)."-1 WHERE username='$ref'");
			if((isset($thisuser[refered])) && ($thisuser[refered] != $ref)) {
				edit_upline(($x+1), $thisuser[refered]);
			}
		}
	}
}
/*
function deleteuser($userinfo) {
	global $Db1, $username, $userid;
	if($username == $userinfo[username] && $userid == $userinfo[userid]) {
		$sql=$Db1->query("DELETE FROM banners WHERE username='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM fbanners WHERE username='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM fads WHERE username='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM ads WHERE username='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM emails WHERE username='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM popups WHERE username='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM game_sites WHERE username='$userinfo[username]'");

		$Db1->query("UPDATE user SET notes='".$userinfo[notes]."\n---------------\nDeleted By User ($vip)' WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM user_deleted WHERE username='$userinfo[username]'");
		$Db1->query("INSERT INTO user_deleted SELECT * FROM user WHERE username='$userinfo[username]'");
		$Db1->query("DELETE FROM user WHERE userid='$userinfo[userid]'");

		$sql=$Db1->query("INSERT INTO logs SET username='".$userinfo[username]."', log='Deleted Account', dsub='".time()."'");
		$sql=$Db1->query("UPDATE user SET refered='' WHERE refered='$userinfo[username]'");
		$sql=$Db1->query("DELETE FROM sessions WHERE user_id='$userinfo[userid]'");
		if($userinfo[refered]) {
			edit_upline(1, $userinfo[refered]);
		}
	}
}
*/

if($action == "delete") {
	if($choice == "No") {
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=profile&".$url_variables."");
		exit;
	}
	else {
		if($thismemberinfo[password] == md5($pwd)) {
			deleteuser($thismemberinfo['userid']);
			$Db1->sql_close();
			header("Location: index.php");
			exit;
		}
		else {
			$Db1->sql_close();
			header("Location: index.php?view=account&ac=profile&".$url_variables."");
			exit;
		}
	}
}
else {
	$includes[content]="
<form action=\"index.php?view=account&ac=delete&action=delete&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
Are You Sure You Want To Delete Your Account?
	<select name=\"choice\">
		<option value=\"No\">No
		<option value=\"Yes\">Yes
	</select><br />
Enter Your Password: <input type=\"password\" name=\"pwd\"><br />
<input type=\"submit\" value=\"Delete Account\">

</form>
	";
}
//**E**//
?>