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
$includes[title]="PTRA Settings";
if(SETTING_PTRA==true) {

if(($action == "save") && ($working == 1)) {

$settings["ptraon"]		=	"$ptraon";
$settings["sellptra"]	=	"$sellptra";
$settings["ptra_approve"] = "$ptra_approve";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=ptra&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=ptra&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

".iif(SETTING_PTRA==true,"
	<tr>
		<td width=\"250\"><b>Paid To Read: </b></td>
		<td><input type=\"checkbox\" name=\"ptraon\" value=\"1\" ".iif($settings[ptraon]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Sell Email Hits?</b></td>
		<td><input type=\"checkbox\" name=\"sellptra\" value=\"1\" ".iif($settings[sellptra]==1," checked=\"checked\"")."></td>
	</tr><tr>
		<td width=\"250\"><b>Require Admin Approval? </b></td>
		<td><input type=\"checkbox\" name=\"ptra_approve\" value=\"1\" ".iif($settings[ptra_approve]==1," checked=\"checked\"")."></td>
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
	$includes[content]="This script version does not have PTRA enabled. Please contact your script supplier for more information.";
}

?>
