<?
$includes[title]="Game911 Settings";
if(SETTING_PTC==true) {

if(($action == "save") && ($working == 1)) {

$settings["game911"]		=	"$gameon";
$settings["game911free"]	=	"$members22";
$settings["game911max"] = "$game911max";
$settings["game911_extra"] = "$game911extra";

include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=911&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=911&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table class=\"tableStyle3\" style=\"width: 500px;\">



".iif(SETTING_PTC==true,"
	<tr>
		<td><b>Game 911 Enabled: </b></td>
		<td><input type=\"checkbox\" name=\"gameon\" value=\"1\" ".iif($settings[game911]==1," checked=\"checked\"")."></td>
	</tr>

	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
")."


</table>
</form>

<br>
	Game 911 added by <a href=\"http://www.latinclicks.info\">LatinClicks</a> as Add-on
";
}
else {
	$includes[content]="This script does not have the 911 Game Enabled. Please contact LatinClicks for more information.";
}

?>
