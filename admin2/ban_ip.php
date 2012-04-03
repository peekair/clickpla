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
$includes[title]="Ban IP Address";

if($action == "go") {
	$found=0;
	if($ban_ip != "") {
		$sql=$Db1->query("SELECT username, userid, notes, email FROM user WHERE last_ip='$ban_ip'");
		while($temp=$Db1->fetch_array($sql)) {
			$found++;
			echo "<!-- $temp[username] -->";
			flush();
			if($ssuspend == 1) {
				$suspend_list.="$temp[username] Suspended!<br />";
				$Db1->query("UPDATE user SET suspended='1', notes='".$temp[notes]."\nSuspended for multiple IP accounts' WHERE userid='$temp[userid]'");
				$Db1->query("DELETE FROM sessions WHERE user_id='$temp[userid]'");
			}
			if($debt == 1) {
				$Db1->query("UPDATE user SET balance='0' WHERE username='$temp[username]'");
			}
			if($list == 1) {
				$accountlist.="$temp[username]\n";
			}
		}
	}
	$includes[content]="
	Completed! $found accounts were found!<br />
		".iif($list==1,"<textarea cols=40 rows=10>$accountlist</textarea><br /><br />")."
	<br />
	$suspend_list<hr>
	";
}

$includes[content].="
This tool will allow you to ban any accounts using a specified IP address.<br /><br />

<form action=\"admin.php?view=admin&ac=ban_ip&action=go&".$url_variables."\" method=\"post\">
Ip Address: <input type=\"text\" name=\"ban_ip\"><br />

<input type=\"checkbox\" name=\"ssuspend\" value=\"1\">Suspend Account<br />
<input type=\"checkbox\" name=\"debt\" value=\"1\">Remove All Earnings<br />
<input type=\"checkbox\" name=\"list\" value=\"1\">Make List Of Accounts<br />

<input type=\"submit\" value=\"Go!\">
</form>

";

?>
