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
$includes[title]="PTP Settings";
if(SETTING_PTP==true) {

if(($action == "save") && ($working == 1)) {

$settings["user_popups"]		=	"$user_popups";
$settings["ptppopup"]			=	"$ptppopup";
$settings["popuponce"]			=	"$popuponce";
$settings["ptpunique"]			=	"$ptpunique";
$settings["ptpuniqueuser"]		=	"$ptpuniqueuser";
$settings["popupon"]			=	"$popupon";
$settings["sellpopups"]			=	"$sellpopups";
$settings["ptpamount"]			=	"$ptpamount";
$settings["no_ref_pay"]			=	"$no_ref_pay";
$settings["ptpon"]				=	"$ptpon";

$settings["ptpallow"]				=	"$ptpallow";



include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=ptp&saved=1&".$url_variables."");
}



$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."

<h2><a href=\"admin.php?view=admin&ac=ptp_allow&".$url_variables."\">PTP Allowed Sites</a></h2>
<form action=\"admin.php?view=admin&ac=settings&action=save&type=ptp&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

	<tr>
		<td width=\"250\"><b>Paid To Promote:</b></td>
		<td><input type=\"checkbox\" name=\"ptpon\" value=\"1\"".iif($settings[ptpon]==1," Checked=\"Checked\"")."> On</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Paid To Promote Amount: </b></small></td>
		<td>$settings[currency]<input type=\"text\" name=\"ptpamount\" value=\"$settings[ptpamount]\" size=\"6\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Only Pay for Allowed Referrers</b></td>
		<td><input type=\"checkbox\" name=\"ptpallow\" value=\"1\"".iif($settings[ptpallow]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Sell Popups? </b></td>
		<td><input type=\"checkbox\" name=\"sellpopups\" value=\"1\"".iif($settings[sellpopups]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Show Popups? </b></td>
		<td><input type=\"checkbox\" name=\"popupon\" value=\"1\"".iif($settings[popupon]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Let Members Manage Popup Ads? </b></td>
		<td><input type=\"checkbox\" name=\"user_popups\" value=\"1\"".iif($settings[user_popups]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Pay Only When Popup Loads? </b></td>
		<td><input type=\"checkbox\" name=\"ptppopup\" value=\"1\"".iif($settings[ptppopup]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Popup Just Once For Each Visitor? </b></td>
		<td><input type=\"checkbox\" name=\"popuponce\" value=\"1\"".iif($settings[popuponce]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Pay Only For Unique Visitors? </b></td>
		<td><input type=\"checkbox\" name=\"ptpunique\" value=\"1\"".iif($settings[ptpunique]==1," Checked=\"Checked\"")."> Yes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Unique Pay Behavior: </b></td>
		<td>
			<select name=\"ptpuniqueuser\">
				<option value=\"0\"".iif($settings[ptpuniqueuser]==0," selected=\"selected\"").">Pay For Site-Unique Hits
				<option value=\"1\"".iif($settings[ptpuniqueuser]==1," selected=\"selected\"").">Pay For Referrer-Unique Hits
			</select>
	</tr>
	<tr>
		<td width=\"250\"><b>Pay If No Referring URL? </b></td>
		<td>
			<select name=\"no_ref_pay\">
				<option value=\"0\"".iif($settings[no_ref_pay]==0," selected=\"selected\"").">No
				<option value=\"1\"".iif($settings[no_ref_pay]==1," selected=\"selected\"").">Yes
			</select>
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
