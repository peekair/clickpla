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
$includes[title]="View Signup Offer";
//**VS**//$setting[ptsu]//**VE**//
//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$sql=$Db1->query("SELECT * FROM ptsuads WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if($ad[username]!=$username) {
	$includes[content]="You do not have permission to this area!";
}
else {
	if($action == "save") {
		$Db1->query("UPDATE ptsuads SET
			upgrade='".addslashes($premOnly)."',
			country='".addslashes($country)."'
			".iif($ad['subtitle_on'],", subtitle='".htmlentities($subtitle)."'")."
		WHERE id='$id'");

		$Db1->sql_close();
		header("Location: index.php?view=account&ac=view_ptsu&id=$id&".$url_variables."");
		exit;
	}
	else {

	$includes[content]="
<form action=\"index.php?view=account&ac=view_ptsu&action=save&id=$id&".$url_variables."\" method=\"post\">
<div style=\"text-align: right\"><a href=\"index.php?view=account&ac=myads&adtype=ptsu&".$url_variables."\">Back To Ad Manager</a></div>
<div align=\"center\">
<table>
	<tr>
		<td width=\"150\">Title: </td>
		<td>$ad[title]</td>
	</tr>
	<tr>
		<td>Target: </td>
		<td><a href=\"$ad[target]\" target=\"_blank\">$ad[target]</a></td>
	</tr>
	<tr>
		<td>Status: </td>
		<td>".
			iif($ad[active]==0,"Pending Approval").
			iif($ad[active]==1,"Approved").
			iif($ad[active]==2,"Denied").
			"</td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td>$ad[credits]</td>
	</tr>
	<tr>
		<td>Class: </td>
		<td>".iif($ad['class']=="P","Points","Cash")."</td>
	</tr>
	<tr>
		<td>Link Value: </td>
		<td>".iif($ad[pamount]==0,"Not Set Yet",iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")."")."</td>
	</tr>
	<tr>
		<td>Signups: </td>
		<td>$ad[signups]</td>
	</tr>
	<tr>
		<td>Signups Today: </td>
		<td>$ad[signups_today]</td>
	</tr>
	<tr>
		<td>Pending Validation: </td>
		<td>$ad[pending]</td>
	</tr>
	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList($ad[country])."</select></td>
	</tr>
	<tr>
	<tr>
		<td>Description:</td>
		<td > <textarea cols=\"50\" rows=\"4\" name=\"subtitle\">$ad[subtitle]</textarea></td>
	</tr>
	<tr>
		<td>Premium Members Only? </td>
		<td><input type=\"checkbox\" name=\"premOnly\" value=\"1\" ".iif($ad[upgrade] == 1,"checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			".iif($ad[signups] == 0 && $ad[pending] == 0,"<input type=\"button\" value=\"Delete Ad\" onclick=\"location.href='index.php?view=account&ac=delete_ptsu&id=$id&".$url_variables."'\">")."
			<input type=\"button\" value=\"Add Credits\" onclick=\"location.href='index.php?view=account&ac=add_credits_ptsu&id=$id&".$url_variables."'\">
		</td>
	</tr>
</table>
</form>
</div>
";
}}
//**E**//
?>
