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
$includes[title]="View Featured Ad";

$sql=$Db1->query("SELECT * FROM fads WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if($ad[username]!=$username) {
	$includes[content]="You do not have permission to this area!";
}
else {
	if($action == "save") {
		$Db1->query("UPDATE fads SET daily_limit='".addslashes($daily_limit)."' WHERE id='$id'");
		
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=view_fad&id=$id&".$url_variables."");
		exit;
	}
	else {
	
	$includes[content]="
<form action=\"index.php?view=account&ac=view_fad&action=save&id=$id&".$url_variables."\" method=\"post\">
<div style=\"text-align: right\"><a href=\"index.php?view=account&ac=myads&adtype=fad&".$url_variables."\">Back To Ad Manager</a></div>
<div align=\"center\">
<table>
	<tr>
		<td width=\"100\">Title: </td>
		<td>$ad[title]</td>
	</tr>
	<tr>
		<td>Target: </td>
		<td><a href=\"$ad[target]\" target=\"_blank\">$ad[target]</a></td>
	</tr>
	<tr>
		<td colspan=2 bgcolor=\"$settings[color2]\">".stripslashes($ad[description])."</td>
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
		<td>Clicks: </td>
		<td>$ad[clicks]</td>
	</tr>
	<tr>
		<td>ClickThru Rate: </td>
		<td>".@($ad[clicks]/$ad[views])."%</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"button\" value=\"Delete Featured Ad\" onclick=\"location.href='index.php?view=account&ac=delete_fad&id=$id&".$url_variables."'\">
			<input type=\"button\" value=\"Add Credits\" onclick=\"location.href='index.php?view=account&ac=add_credits_fad&id=$id&".$url_variables."'\">
		</td>
	</tr>
</table>
</form>
</div>
";
}}

?>
