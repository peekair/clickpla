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
$includes[title]="Click Exchange Settings";
if(SETTING_CE==true) {

if(($action == "save") && ($working == 1)) {

$settings["ce_on"]		=	"$ce_on";
$settings["ce_ratio1"]	=	"$ce_ratio1";
$settings["ce_ratio2"]	=	"$ce_ratio2";
$settings["ce_time"]	=	"$ce_time";
$settings["ce_approve"]	=	"$ce_approve";

include("admin2/settings/update.php");
updatesettings($settings);
	
//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=clickx&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=clickx&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

".iif(SETTING_CE==true,"
	<tr>
		<td width=\"250\"><b>Click Exchange: </b></td>
		<td><input type=\"checkbox\" name=\"ce_on\" value=\"1\" ".iif($settings[ce_on]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Require Admin Approval? </b></td>
		<td><input type=\"checkbox\" name=\"ce_approve\" value=\"1\" ".iif($settings[ce_approve]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Earning Ratio: </b> <small>(Views/Credits)</small></td>
		<td><input type=\"text\" name=\"ce_ratio1\" value=\"$settings[ce_ratio1]\" size=\"3\"> / <input type=\"text\" name=\"ce_ratio2\" value=\"$settings[ce_ratio2]\" size=\"3\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Surf Time: </b></small></td>
		<td><input type=\"text\" name=\"ce_time\" value=\"$settings[ce_time]\" size=\"3\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
")."


</table>
<div align=\"right\"></div>
</form>
";
}
else {
	$includes[content]="This script version does not have PTR enabled. Please contact your script supplier for more information.";
}

?>
