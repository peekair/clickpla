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
$includes[title]="View Banner";

$sql=$Db1->query("SELECT * FROM banners WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if($ad[username]!=$username) {
	$includes[content]="You do not have permission to this area!";
}
else {

	if($action == "save") {
		$Db1->query("UPDATE banners SET daily_limit='".addslashes($daily_limit)."' WHERE id='$id'");
		
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=view_banner&id=$id&".$url_variables."");
		exit;
	}
	else {
	
	$includes[content]="


<form action=\"index.php?view=account&ac=view_banner&action=save&id=$id&".$url_variables."\" method=\"post\">
<div style=\"text-align: right\"><a href=\"index.php?view=account&ac=myads&adtype=banner&".$url_variables."\">Back To Ad Manager</a></div>
<div align=\"center\">
<table>
	<tr>
		<td colspan=2 align=\"center\"><img src=\"$ad[banner]\"></td>
	</tr>
	<tr>
		<td width=\"100\">Title: </td>
		<td>$ad[title]</td>
	</tr>
	<tr>
		<td>Target: </td>
		<td><a href=\"$ad[target]\" target=\"_blank\">$ad[target]</a></td>
	</tr>
	<tr>
		<td>Banner Url: </td>
		<td><a href=\"$ad[banner]\" target=\"_blank\">$ad[banner]</a></td>
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
		<td>".round(@($ad[clicks]/$ad[views]*100),3)."%</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"button\" value=\"Delete Banner\" onclick=\"location.href='index.php?view=account&ac=delete_banner&id=$id&".$url_variables."'\">
			<input type=\"button\" value=\"Add Credits\" onclick=\"location.href='index.php?view=account&ac=add_credits_banner&id=$id&".$url_variables."'\">
		</td>
	</tr>
</table>
</form>
</div>
";
	}
}
?>
