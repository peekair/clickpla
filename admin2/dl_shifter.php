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
$includes[title]="Downline Shifter";


function edit_upline($x, $ref) {
	global $username, $Db1;
	if($x <= 5) {
		if($username != $ref) {
			$sql=$Db1->query("SELECT * FROM user WHERE username='$ref'");
			$thisuser=$Db1->fetch_array($sql);
			$sql=$Db1->query("UPDATE  user SET refstat='3', referrals".($x)."=referrals".($x)."-1 WHERE username='$ref'");
			if((isset($thisuser[refered])) && ($thisuser[refered] != $ref)) {
				edit_upline(($x+1), $thisuser[refered]);
			}
		}
	}
}

if($action == "shift") {
	$sql=$Db1->query("SELECT * FROM user WHERE refered='$user'");
	$sql=$Db1->fetch_array($member);
	edit_upline(1,$member[refered]);
}

$includes[content]="
<form action=\"admin.php?view=admin&ac=dl_shifter&action=shift&".$url_variables."\" method=\"post\">
Username: <input type=\"text\" name=\"user\"><br>
<input type=\"submit\" value=\"Shift Downline\">
</form>
";

?>
