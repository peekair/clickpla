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
$includes[title]="Cheat Check Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["cheat_check_perc"]	=	"$cheat_check_perc";
$settings["cheat_loads"]		=	"$cheat_loads";
$settings["min_cheat_int"]		=	"$min_cheat_int";





include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=cheat&saved=1&".$url_variables."");
}

for($x=1; $x<=5; $x++) {
	$reflevels.="<option value=\"$x\"".iif($x==$settings[ref_levels]," selected=\"selected\"").">$x";
}

$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=cheat&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

	<tr>
		<td width=\"250\"><b>Cheat Check %: </b>".show_help("How often should members be given the cheat check? 0 = disable : 50 = 1 out of 2")."</td>
		<td><input type=\"text\" name=\"cheat_check_perc\" value=\"$settings[cheat_check_perc]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Cheat Interval: </b>".show_help("Members cannot be chosen for the cheat check more than once within this time frame.")."</td>
		<td><input type=\"text\" name=\"min_cheat_int\" value=\"$settings[min_cheat_int]\" size=3> Minutes</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Loads 'till Fail: </b>".show_help("After how many loads of the cheat check page should it be considered a fail?")."</td>
		<td><input type=\"text\" name=\"cheat_loads\" value=\"$settings[cheat_loads]\" size=3> Minutes</td>
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
