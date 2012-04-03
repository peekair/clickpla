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
$includes[title]="Edit Popup Message";

function save($src) {
	$file = "./popupMsg.php";
	$handle = fopen($file, "w+");
	fwrite($handle, $src);
	fclose($handle);
}

function read() {
	if(is_file("./popupMsg.php")) {
		$file = "./popupMsg.php";
		$handle = fopen($file, "r");
		$src = fread($handle, filesize($file));
		fclose($handle);
	}
	return $src;
}

function saveSettings($newSettings) {
	global $settings, $Db1;
	foreach($newSettings as $k => $v) {
		$settings[$k]=$v;
	}
	include("admin2/settings/update.php");
	updatesettings($settings);
	$Db1->sql_close();
	header("Location: admin.php?ac=popupMsg&".$url_variables."");
	exit;
}

if($action == "save") {
	save($popupMsg);
	saveSettings(array(
		"popupMsgTitle"=>urlencode($popupMsgTitle),
		"popupMsgActive"=>"$popupMsgActive"
	));
}

if($action == "reset") {
	$Db1->query("UPDATE user SET hidePopup=0");
	$Db1->sql_close();
	header("Location: admin.php?ac=popupMsg&".$url_variables."");
	exit;
}


$sql=$Db1->query("SELECT COUNT(userid) as total FROM user WHERE hidePopup=1");
$temp=$Db1->fetch_array($sql);


$includes[content]="

<form action=\"admin.php?ac=popupMsg&action=save&".$url_variables."\" method=\"post\">
Active? <input type=\"checkbox\" value=\"1\" name=\"popupMsgActive\" ".iif($settings[popupMsgActive]==1,"checked=\"checked\"")."><br />
Title: <input type=\"text\" name=\"popupMsgTitle\" size=50  value=\"".htmlentities(urldecode($settings[popupMsgTitle]))."\"><br />
<textarea name=\"popupMsg\" cols=80 rows=20>".stripslashes(read())."</textarea><br />
<br />
<input type=\"submit\" value=\"Save\">
</form>

<hr>
Current Popup Viewed By <strong>$temp[total]</strong> Members!<br />
<input type=\"button\" value=\"Reset Popup\" onclick=\"location.href='admin.php?ac=popupMsg&action=reset&".$url_variables."'\">

<hr>
You can use <strong>\$thismemberinfo[name]</strong> in the title to display the member's name!

<hr>
<input type=\"button\" value=\"Preview Popup!\" onclick=\"location.href='admin.php?ac=popupMsg&preview=true&".$url_variables."'\"> <em>must be saved first!</em>

";

if($preview == true) include("templates/$settings[template]/messagePopup.php");



?>