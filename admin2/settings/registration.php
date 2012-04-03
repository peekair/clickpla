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
$includes[title]="Registration Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

//$settings["point_ratio"]	= 	"$point_ratio";



include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=registration&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=registration&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td width=\"250\"><b>Address: </b></td>
		<td>
			<select name=\"register_address\">
				<option value=\"0\" ".iif($settings[register_address]==0,"selected=\"selected\"").">Hide
				<option value=\"1\" ".iif($settings[register_address]==1,"selected=\"selected\"").">Show
				<option value=\"2\" ".iif($settings[register_address]==2,"selected=\"selected\"").">Require
			</select>
		</td>
	</tr>

	<tr>
		<td width=\"250\"><b>City: </b></td>
		<td>
			<select name=\"register_city\">
				<option value=\"0\" ".iif($settings[register_city]==0,"selected=\"selected\"").">Hide
				<option value=\"1\" ".iif($settings[register_city]==1,"selected=\"selected\"").">Show
				<option value=\"2\" ".iif($settings[register_city]==2,"selected=\"selected\"").">Require
			</select>
		</td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>State: </b></td>
		<td>
			<select name=\"register_state\">
				<option value=\"0\" ".iif($settings[register_state]==0,"selected=\"selected\"").">Hide
				<option value=\"1\" ".iif($settings[register_state]==1,"selected=\"selected\"").">Show
				<option value=\"2\" ".iif($settings[register_state]==2,"selected=\"selected\"").">Require
			</select>
		</td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>Zip: </b></td>
		<td>
			<select name=\"register_zip\">
				<option value=\"0\" ".iif($settings[register_zip]==0,"selected=\"selected\"").">Hide
				<option value=\"1\" ".iif($settings[register_zip]==1,"selected=\"selected\"").">Show
				<option value=\"2\" ".iif($settings[register_zip]==2,"selected=\"selected\"").">Require
			</select>
		</td>
	</tr>
	
	<tr>
		<td width=\"250\"><b>Phone: </b></td>
		<td>
			<select name=\"register_phone\">
				<option value=\"0\" ".iif($settings[register_phone]==0,"selected=\"selected\"").">Hide
				<option value=\"1\" ".iif($settings[register_phone]==1,"selected=\"selected\"").">Show
				<option value=\"2\" ".iif($settings[register_phone]==2,"selected=\"selected\"").">Require
			</select>
		</td>
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
