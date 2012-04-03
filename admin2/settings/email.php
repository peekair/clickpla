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
$includes[title]="Email Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["email_from_name"]	=	"$email_from_name";
$settings["email_from_address"]	=	"$email_from_address";
$settings["email_method"]		=	"$email_method";
$settings["email_username"]		=	"$email_username";
$settings["email_password"]		=	"$email_password";
$settings["email_host"]			=	"$email_host";
$settings["email_helo"]			=	"$email_helo";


include("admin2/settings/update.php");
updatesettings($settings);


//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=email&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=email&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">
	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt; color: darkblue\">Email Settings</font></b></td>
	</tr>
	<tr>
		<td width=\"250\"><b>From Name: </b></td>
		<td><input type=\"text\" name=\"email_from_name\" value=\"$settings[email_from_name]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>From Address: </b></td>
		<td><input type=\"text\" name=\"email_from_address\" value=\"$settings[email_from_address]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Mail Method: </b></td>
		<td>
			<select name=\"email_method\">
				<option value=\"smtp\"".iif($settings[email_method]=="smtp"," selected=\"selected\"").">SMTP
				<option value=\"sendmail\"".iif($settings[email_method]=="sendmail"," selected=\"selected\"").">Sendmail
			</select>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt; color: darkblue\">SMTP Settings</font></b></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Username: </b></td>
		<td><input type=\"text\" name=\"email_username\" value=\"$settings[email_username]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Password: </b></td>
		<td><input type=\"text\" name=\"email_password\" value=\"$settings[email_password]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>SMTP Host: </b></td>
		<td><input type=\"text\" name=\"email_host\" value=\"$settings[email_host]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Mail Host [HELO]: </b></td>
		<td><input type=\"text\" name=\"email_helo\" value=\"$settings[email_helo]\"></td>
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
