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
$includes[title]="Paid To Signup Settings";
if(SETTING_PTSU==true) {

if(($action == "save") && ($working == 1)) {

$settings["ptsu_require_act"]		=	"$ptsu_require_act";
$settings["ptsuon"]		=	"$ptsuon";

$settings["ptsu_mode"]		=	"$ptsu_mode";

$settings["ptsuAdvTimeout"]		=	"$ptsuAdvTimeout";
$settings["ptsudefault"]		=	"$ptsudefault";






include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=ptsu&saved=1&".$url_variables."");
}



$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=ptsu&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

	<tr>
		<td width=\"250\"><b>Paid To Signup:</b></td>
		<td><input type=\"checkbox\" name=\"ptsuon\" value=\"1\"".iif($settings[ptsuon]==1," Checked=\"Checked\"")."> On</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Require New Offer Admin Activation:</b></td>
		<td><input type=\"checkbox\" name=\"ptsu_require_act\" value=\"1\"".iif($settings[ptsu_require_act]==1," Checked=\"Checked\"")."> On</td>
	</tr>
	<tr>
		<td width=\"250\"><b>New Signup Verification Mode:</b></td>
		<td><select name=\"ptsu_mode\"
			<option value=\"0\" ".iif($settings[ptsu_mode]==0," selected=\"selected\"").">Admin Approval
			<option value=\"2\" ".iif($settings[ptsu_mode]==2," selected=\"selected\"").">Advertiser Approval
			
		</td>
	</tr>
    
    				<td><B>Default Class: </B> </td>
				<td><select name=\"ptsudefault\">
  		<option value=\"C\" ".iif($settings[ptsudefault]==C," selected=\"selected\"").">Cash
        	<option value=\"P\" ".iif($settings[ptsudefault]==P," selected=\"selected\"").">Points
			</td>
                
                
	<tr>
		<td width=\"250\"><b>Advertiser Approval - Auto Approve After:</b></td>
		<td><input type=\"text\" name=\"ptsuAdvTimeout\" value=\"".$settings[ptsuAdvTimeout]."\" size=4> Days</td>
	</tr>
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
<div align=\"right\"></div>
</form>
";
}
else {
	$includes[content]="This script version does not have PTP enabled. Please contact your script supplier for more information.";
}

?>
