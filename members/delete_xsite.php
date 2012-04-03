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
$includes[title]="Delete Click Exchange Site";
//**VS**//$setting[ce]//**VE**//
//**S**//
if(SETTING_surfS != true) {
	haultscript();
}
$sql=$Db1->query("SELECT * FROM xsites WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if($ad[username]!=$username) {
	$includes[content]="You do not have permission to delete this site!";
}
else {
	if($step == "2") {
		$sql=$Db1->query("DELETE FROM xsites WHERE id='$id'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=myads&adtype=xsites&".$url_variables."");
	}
	$includes[content]="
<div align=\"center\"><br />
Are You Sure You Want To Delete This Ad?<br />

<input type=\"button\" value=\"Yes\" onclick=\"location.href='index.php?view=account&ac=delete_xsite&&step=2&id=$id&".$url_variables."'\">
<input type=\"button\" value=\"No\" onclick=\"location.href='index.php?view=account&ac=myads&adtype=xsites&".$url_variables."'\">

</div>
	";
}
//**E**//
?>