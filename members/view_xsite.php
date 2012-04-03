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
$includes[title]="View Click Exchange Site";
//**VS**//$setting[ce]//**VE**//
//**S**//
if(SETTING_surfS != true) {
	haultscript();
}
else {
	$sql=$Db1->query("SELECT * FROM xsites WHERE id='$id'");
	$ad=$Db1->fetch_array($sql);
}
//**E**//


if($ad[username]!=$username) {
	$includes[content]="You do not have permission to this area!";
}
else {
	if($action == "save") {
		$Db1->query("UPDATE xsites SET daily_limit='".addslashes($daily_limit)."', country='".addslashes($country)."', upgrade='".addslashes($premOnly)."' WHERE id='$id'");
		
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=view_xsite&id=$id&".$url_variables."");
		exit;
	}
	else {
	
	$includes[content]="
<form action=\"index.php?view=account&ac=view_xsite&action=save&id=$id&".$url_variables."\" method=\"post\">
<div style=\"text-align: right\"><a href=\"index.php?view=account&ac=myads&adtype=xsites&".$url_variables."\">Back To Ad Manager</a></div>
<div align=\"center\">
<table>
	<tr>
		<td width=\"100\">Title: </td>
		<td>$ad[title]</td>
	</tr>
	<tr>
		<td>URL: </td>
		<td><a href=\"$ad[target]\" target=\"_blank\">$ad[target]</a></td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td>$ad[credits]</td>
	</tr>
	<tr>
		<td>Views: </td>
		<td>$ad[views]</td>
	</tr>
	<tr>
		<td>Views Today: </td>
		<td>$ad[views_today]</td>
	</tr>
	<tr>
		<td>Daily Limit: </td>
		<td><input type=\"text\" name=\"daily_limit\" value=\"$ad[daily_limit]\" size=4> <small>0 for no limit</small></td>
	</tr>
	<tr>
		<td>Premium Members Only? </td>
		<td><input type=\"checkbox\" name=\"premOnly\" value=\"1\" ".iif($ad[upgrade] == 1,"checked=\"checked\"")."></td>
	</tr>
	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList($ad[country])."</select></td>
	</tr>
	<tr>
		<td>Status: </td>
		<td>".iif($ad[active] == 1,"<font color=\"darkgreen\">Active","<font color=\"darkblue\">Waiting Approval")."</font></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"button\" value=\"Delete Site\" onclick=\"location.href='index.php?view=account&ac=delete_xsite&id=$id&".$url_variables."'\">
			<input type=\"button\" value=\"Add Credits\" onclick=\"location.href='index.php?view=account&ac=add_credits_xsite&id=$id&".$url_variables."'\">
		</td>
	</tr>
</table>
</form>
</div>
";
}}

?>
