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
$includes[title]="Lottery Settings";
//**S**//
if(($action == "save") && ($working == 1)) {
$settings["lottery_enabled"]	=	"$lottery_enabled";
$settings["lottery_price1st"]= 	"$lottery_price1st";
$settings["lottery_ticketprice"]	=	"$lottery_ticketprice";
$settings["lottery_price2nd"]	=	"$lottery_price2nd";
$settings["lottery_price4"]			=	"$lottery_price4";
$settings["lottery_price3"]			=	"$lottery_price3";



include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=lottery&saved=1&".$url_variables."");
}

for($x=1; $x<=5; $x++) {
	$reflevels.="<option value=\"$x\"".iif($x==$settings[ref_levels]," selected=\"selected\"").">$x";
}

$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=lottery&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

	<tr>
		<td width=\"250\"><b>Lottery Enabled?: </b></td>
		<td><input type=\"checkbox\" name=\"lottery_enabled\" value=\"1\"".iif($settings[lottery_enabled] == 1," checked=\"checked\"")."></td>
	</tr>
<br>
	<tr>
		<td width=\"250\"><b>Lottery Ticket Price: </b></td>
		<td><input type=\"text\" name=\"lottery_ticketprice\" value=\"$settings[lottery_ticketprice]\">( How much a member needs to pay for a number)</td>
	</tr>
	<tr>
		<td width=\"250\"><b>How much win 1st Winner: </b></td>
		<td><input type=\"text\" name=\"lottery_price1st\" value=\"$settings[lottery_price1st]\"> (Winning amount for 1st ticket draw)</td>
	</tr>

	<tr>
		<td width=\"250\"><b>How much win 2nd Winner: </b></td>
		<td><input type=\"text\" name=\"lottery_price2nd\" value=\"$settings[lottery_price2nd]\"> </td>
	</tr>

	<tr>
		<td width=\"250\"><b>How much win the 3rd Winner?: </b></td>
		<td><input type=\"text\" name=\"lottery_price3\" value=\"$settings[lottery_price3]\"> </td>
	</tr>
	<tr>
		<td width=\"250\"><b>How much win the 4th Winner?: </b></td>
		<td><input type=\"text\" name=\"lottery_price4\" value=\"$settings[lottery_price4]\"> </td>
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
