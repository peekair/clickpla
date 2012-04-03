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


$settings["iconOn"]			=	$iconOn;
$settings["iconCost"]		=	$iconCost;
$settings["iconPixels"]		=	$iconPixels;

$settings["subtitleOn"]		=	$subtitleOn;
$settings["subtitleCost"]	=	$subtitleCost;


$settings["showPremOnlyMsg"]	=	"$showPremOnlyMsg";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=addons&saved=1&".$url_variables."");
}

for($x=1; $x<=5; $x++) {
	$reflevels.="<option value=\"$x\"".iif($x==$settings[ref_levels]," selected=\"selected\"").">$x";
}

$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=addons&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Ad Icons: </b>".show_help("Allow ad icons?")."</td>
		<td><input type=\"checkbox\" name=\"iconOn\" value=\"1\"".iif($settings[iconOn] == 1," checked=\"checked\"")."></td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>Max Icon Pixels: </b>".show_help("Max resolution ad icons can be)")."</td>
		<td><input type=\"text\" name=\"iconPixels\" value=\"$settings[iconPixels]\" size=4> Pixels</td>
	</tr>


	<tr>
		<td width=\"250\"><b>Ad Subtitles: </b>".show_help("Allow ad subtitles?")."</td>
		<td><input type=\"checkbox\" name=\"subtitleOn\" value=\"1\"".iif($settings[subtitleOn] == 1," checked=\"checked\"")."></td>
	</tr>
	
	
	
	<tr>
		<td><b>Display 'Premium-Only-Ads' Alert?</b></td>
		<td><input type=\"checkbox\" name=\"showPremOnlyMsg\" value=\"1\" ".iif($settings[showPremOnlyMsg]==1," checked=\"checked\"")."></td>
	</tr>


	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>

</table>
<div align=\"right\"></div>
</form>
";
//**E**//
?>
