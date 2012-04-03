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
$includes[title]="Member Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["withdraw_min"]	= 	"$withdraw_min";
$settings["withdraw_premium"]	= 	"$withdraw_premium";

	include("admin2/settings/update.php");
	updatesettings($settings);

	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=withdraw&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=withdraw&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Withdraw Minimum*: </b><br /><small>What is the minimal withdraw amount?</small></td>
		<td><input type=\"text\" name=\"withdraw_min\" value=\"$settings[withdraw_min]\" size=\"3\"></td>
	</tr>
	
	
	<tr>
		<td width=\"250\"><b>Limit Withdraws:</b><br /><small>Allow only Premium members to request their earnings</small></td>
		<td><input type=\"checkbox\" name=\"withdraw_premium\" value=\"1\"".iif($settings[withdraw_premium]==1," Checked=\"Checked\"")."></td>
	</tr>
	
	
	
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	
</table>
<div align=\"right\"></div>
</form>
<small>
* This does not effect the actual withdraw minimum! This is only to control the displayed minimum on the homepage, and to figure admin balance stats.
To modify the actual payout method minimums, goto [admin->payouts->payout options]
</small>
";
//**E**//
?>
