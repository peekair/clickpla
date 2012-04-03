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
$includes[title]="Poll Settings";
//**S**//
if(($action == "save") && ($working == 1)) {
	if($resetpoll == 1) {
		$sql=$Db1->query("DELETE FROM poll_history");
		$poll_votes="";
	}
	else {
		$poll_votes=$settings[poll_votes];
	}

$settings["alt_fb_poll"]=	"$alt_fb_poll";
$settings["poll_active"]=	"$poll_active";
$settings["poll_title"]	=	"$poll_title";
$settings["poll_a1"]	=	"$poll_a1";
$settings["poll_a2"]	=	"$poll_a2";
$settings["poll_a3"]	=	"$poll_a3";
$settings["poll_a4"]	=	"$poll_a4";
$settings["poll_a5"]	=	"$poll_a5";
$settings["poll_votes"] = 	"$poll_votes";

include("admin2/settings/update.php");
updatesettings($settings);


//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=poll&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."

New poll system! See the manage polls section.

<!--
<form action=\"admin.php?view=admin&ac=settings&action=save&type=poll&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt; color: darkblue\">Poll Settings</font></b></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Active?</b></td>
		<td><input type=\"checkbox\" name=\"poll_active\" value=\"1\" ".iif($settings[poll_active]==1," checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Rotate Poll:</b><br /><small>Rotate the poll & featured banner?</small></td>
		<td><input type=\"checkbox\" name=\"alt_fb_poll\" value=\"1\"".iif($settings[alt_fb_poll]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Reset Votes?</b><br /><small>Check this box to reset votes</small></td>
		<td><input type=\"checkbox\" name=\"resetpoll\" value=\"1\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Title</b></td>
		<td><input type=\"text\" name=\"poll_title\" value=\"$settings[poll_title]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Answer 1</b></td>
		<td><input type=\"text\" name=\"poll_a1\" value=\"$settings[poll_a1]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Answer 2</b></td>
		<td><input type=\"text\" name=\"poll_a2\" value=\"$settings[poll_a2]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Answer 3</b></td>
		<td><input type=\"text\" name=\"poll_a3\" value=\"$settings[poll_a3]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Answer 4</b></td>
		<td><input type=\"text\" name=\"poll_a4\" value=\"$settings[poll_a4]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Poll Answer 5</b></td>
		<td><input type=\"text\" name=\"poll_a5\" value=\"$settings[poll_a5]\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>


</table>
<div align=\"right\"></div>
</form>

--> 

";
//**E**//
?>
