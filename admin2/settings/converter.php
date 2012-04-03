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

$settings["balance_convert_ratio"]	= 	"$balance_convert_ratio";
$settings["point_convert_ratio"]	= 	"$point_convert_ratio";
$settings["gpoint_convert_ratio"]	= 	"$gpoint_convert_ratio";
$settings["gcredit_convert_ratio"]	= 	"$gcredit_convert_ratio";
$settings["link_convert_ratio"]		= 	"$link_convert_ratio";
$settings["email_convert_ratio"]	= 	"$email_convert_ratio";
$settings["popup_convert_ratio"]	= 	"$popup_convert_ratio";
$settings["banner_convert_ratio"]	= 	"$banner_convert_ratio";
$settings["fbanner_convert_ratio"]	= 	"$fbanner_convert_ratio";
$settings["fad_convert_ratio"]	 	= 	"$fad_convert_ratio";
$settings["ptra_convert_ratio"]	 	= 	"$ptra_convert_ratio";


include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=converter&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=converter&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Balance Convert Ratio: </b></td>
		<td>$settings[currency]<input type=\"text\" name=\"balance_convert_ratio\" value=\"$settings[balance_convert_ratio]\" size=\"5\"> (1)</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Point Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"point_convert_ratio\" value=\"$settings[point_convert_ratio]\" size=\"5\"></td>
	</tr>".iif(SETTING_GAMES==true,"
	<tr>
		<td width=\"250\"><b>Game Point Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"gpoint_convert_ratio\" value=\"$settings[gpoint_convert_ratio]\" size=\"5\"> (".@(@1/$settings[game_points_ratio]*1000).")</td>
	</tr>")."".iif(SETTING_GAMES==true,"
	<tr>
		<td width=\"250\"><b>Game Credit Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"gcredit_convert_ratio\" value=\"$settings[gcredit_convert_ratio]\" size=\"5\"> (".@(@1/$settings[ghit_ratio]*1000).")</td>
	</tr>")."".iif(SETTING_PTC==true,"
	<tr>
		<td width=\"250\"><b>Link Credit Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"link_convert_ratio\" value=\"$settings[link_convert_ratio]\" size=\"5\"> (".@round(@1/$settings[class_d_ratio]*1000).")</td>
	</tr>")."".iif(SETTING_PTR==true,"
	<tr>
		<td width=\"250\"><b>Email Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"email_convert_ratio\" value=\"$settings[email_convert_ratio]\" size=\"5\"> (".@round(@1/$settings[ptr_ratio]*1000).")</td>
	</tr>")."".iif(SETTING_PTRA==true,"
	<tr>
		<td width=\"250\"><b>PTR Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"ptra_convert_ratio\" value=\"$settings[ptra_convert_ratio]\" size=\"5\"> (".@round(@1/$settings[ptr_d_ratio]*1000).")</td>
	</tr>")."".iif(SETTING_PTP==true,"
	<tr>
		<td width=\"250\"><b>Popup Credit Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"popup_convert_ratio\" value=\"$settings[popup_convert_ratio]\" size=\"5\"> (".@round(@1/$settings[popup_ratio]*1000).")</td>
	</tr>")."
	<tr>
		<td width=\"250\"><b>Banner Credit Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"banner_convert_ratio\" value=\"$settings[banner_convert_ratio]\" size=\"5\"> (".@round(@1000*$settings[banner_ratio]).")</td>
	</tr>
	<tr>
		<td width=\"250\"><b>F. Banner Credit Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"fbanner_convert_ratio\" value=\"$settings[fbanner_convert_ratio]\" size=\"5\"> (".@round(@1000*$settings[fbanner_ratio]).")</td>
	</tr>
	<tr>
		<td width=\"250\"><b>F. Ad Credit Convert Ratio: </b></td>
		<td><input type=\"text\" name=\"fad_convert_ratio\" value=\"$settings[fad_convert_ratio]\" size=\"5\"> (".@round(@1000*$settings[fad_ratio]).")</td>
	</tr>
		
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	
</table>
<div align=\"right\"></div>

<br />
(suggested values)
</form>
";
//**E**//
?>
