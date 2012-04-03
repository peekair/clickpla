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
$includes[title]="Restructure Downlines";
function edit_upline($x, $ref) {
	global $Db1;
	echo "<!-- $ref -->\n";
	flush();
	if($x <= 5) {
		$sql=$Db1->query("SELECT * FROM user WHERE username='".addslashes($ref)."'");
		$thisuser=$Db1->fetch_array($sql);
		$sql=$Db1->query("UPDATE user SET referrals".($x)."=referrals".($x)."+1, referrals=referrals+1 WHERE username='".addslashes($ref)."'");
		if($thisuser[refered] != "") {
			edit_upline(($x+1), $thisuser[refered]);
		}
	}
}

if($start == 1) {
	$Db1->query("UPDATE user SET 
	referrals1=0,
	referrals2=0,
	referrals3=0,
	referrals4=0,
	referrals5=0,
	referrals=0,
	updated='0'
	");
	$action = "go";
}

if($action == "go") {
	echo "Downline stats are being restructured. Do not close this window or press any browser action buttons (back, foward, stop, refresh, ect)";
	$sql=$Db1->query("SELECT * FROM user WHERE updated='0' LIMIT 1000");
	while($user=$Db1->fetch_array($sql)) {
		if($user[refered] != "") {
			edit_upline(1, $user[refered]);
		}
		$Db1->query("UPDATE user SET updated='1' WHERE username='".addslashes($user[username])."'");
	}
	$sql=$Db1->query("SELECT * FROM user WHERE updated='0'");
	if($Db1->num_rows() != 0) {
		$Db1->sql_close();
		echo "
	<script>
	location.href='admin.php?view=admin&ac=fix&action=go&".$url_variables."'
	</script>
		";
		exit;
	}
	else {
		$includes[content]="Restructure Complete!";
	}
}
else {
	$includes[content]="This feature allows you to completely restructure the downline stats for every member<br /><br /><a href=\"admin.php?view=admin&ac=fix&start=1&".$url_variables."\">Click Here To Restructure The Site</a>";
}

?>
