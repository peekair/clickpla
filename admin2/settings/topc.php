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
$includes[title]="Top Clicker Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["top_clickers"]	 	= 	"$top_clickers";
$settings["top_clickers_show_clicks"]	= 	"$top_clickers_show_clicks";
$settings["top_clickers_show"]			= 	"$top_clickers_show";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=topc&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=topc&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Daily Top Clickers</b><br /><small>Show \"Todays Top..\" stats to the left</small></td>
		<td><input type=\"checkbox\" name=\"top_clickers\" value=\"1\" ".iif($settings[top_clickers]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Show Clicks</b><br /><small>Show number of clicks per top user</small></td>
		<td><input type=\"checkbox\" name=\"top_clickers_show_clicks\" value=\"1\" ".iif($settings[top_clickers_show_clicks]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b># Top Clickers</b><br /><small>How many top clickers to show</small></td>
		<td><input type=\"text\" name=\"top_clickers_show\" value=\"$settings[top_clickers_show]\"></td>
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
