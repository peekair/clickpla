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
$includes[title]="ad Blocker";



if($action == "block") {
	if($ad != "") {
		$Db1->query("DELETE FROM ad_block WHERE ad='$ad'");
		$Db1->query("INSERT INTO ad_block SET ad='$ad'");
	}
}

if($action == "unblock") {
	$Db1->query("DELETE FROM ad_block WHERE ad='$ad'");
}

$sql = $Db1->query("SELECT * FROM ad_block ORDER BY ad");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[ad]\">$temp[ad]";
}

$includes[content]="
<small>This tool allows you to keep specific URLS from being credited with advertising credits. For example, if someone keeps making fraud payments from different accounts promoting http://www.domain.com/?ref=user, you can block out <i>domain.com?ref=user</i>. You can also block out <i>domain.com</i> or <i>ref=user</i> and it will work. Be aware, if you block <i>domain.com</i>, then ALL ads that contain <i>domain.com</i> will be blocked.
</small>
<br /><br />
<div align=\"center\">

<form action=\"admin.php?view=admin&ac=ad_blocker&action=block&".$url_variables."\" method=\"post\" onsubmit=\"return confirm('Are you sure you want to block this ad?')\">
<b>Block Ad</b><br />
Ad: <input type=\"text\" name=\"ad\"> <input type=\"submit\" value=\"Block Ad\"><br />
<small>Examples: domain.com, ref=username, domain.com/?ref=user</b></small>
</form>


<form action=\"admin.php?view=admin&ac=ad_blocker&action=unblock&".$url_variables."\" method=\"post\" name=\"form2\">
<select name=\"ad\" size=5>
	$list
</select>
<br />
<input type=\"submit\" value=\"Unblock Ad\"><br />

</form>

</div>

Any credits that are attempted to be added to a blocked ad will be deleted and lost!
<br /><br />
A '382 error' will be returned to any user trying to create an add that is blocked

";

?>
