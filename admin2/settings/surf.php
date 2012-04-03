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
$includes[title]="Converter Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["surf_on"] 	 = 	"$surf_on";
$settings["surf_type"]	 	 = 	"$surf_type";
$settings["surf_credits"]	 = 	"$surf_credits";
$settings["surf_balance"]	 = 	"$surf_balance";
$settings["surf_time"]	 	 = 	"$surf_time";
$settings["surf_act"]		=		"$surf_act";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=surf&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=surf&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Surf On: </b></td>
		<td><input type=\"checkbox\" name=\"surf_on\" value=\"1\" ".iif($settings[surf_on]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Require Site Activation: </b></td>
		<td><input type=\"checkbox\" name=\"surf_act\" value=\"1\" ".iif($settings[surf_act]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Balance Convert Ratio: </b></td>
		<td><select name=\"surf_type\">
			<option value=\"0\"".iif($settings[surf_type]==0," selected=\"selected\"").">Auto
			<option value=\"1\"".iif($settings[surf_type]==1," selected=\"selected\"").">Manual
		</select></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Surf Credits: </b><br /><small>How many surf credits per click?</small></td>
		<td><input type=\"text\" name=\"surf_credits\" value=\"$settings[surf_credits]\" size=\"5\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Surf Balance: </b><br /><small>How much cash per click?</small></td>
		<td>$settings[currency]<input type=\"text\" name=\"surf_balance\" value=\"$settings[surf_balance]\" size=\"5\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Surf Time: </b></td>
		<td><input type=\"text\" name=\"surf_time\" value=\"$settings[surf_time]\" size=\"5\"></td>
	</tr>
		
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	
</table>
</form>
";
//**E**//
?>
