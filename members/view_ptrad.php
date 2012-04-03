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
$includes[title]="View PTR Ad";
//**VS**//$setting[ptra]//**VE**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$sql=$Db1->query("SELECT * FROM ptrads WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if($ad[username]!=$username) {
	$includes[content]="You do not have permission to this area!";
}
else {
	if($action == "save") {
		$Db1->query("UPDATE ptrads SET
			daily_limit='".addslashes($daily_limit)."',
			country='".addslashes($country)."',
			upgrade='".addslashes($premOnly)."'
			".iif($ad['subtitle_on'],", subtitle='".htmlentities($subtitle)."'")."
		WHERE id='$id'");

		$Db1->sql_close();
		header("Location: index.php?view=account&ac=view_ptrad&id=$id&".$url_variables."");
		exit;
	}
	else {

	$includes[content]="
<form action=\"index.php?view=account&ac=view_ptrad&action=save&id=$id&".$url_variables."\" method=\"post\">
<div style=\"text-align: right\"><a href=\"index.php?view=account&ac=myads&adtype=ptrads&".$url_variables."\">Back To Ad Manager</a></div>
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
		<td colspan=2><textarea cols=35 rows=6>$ad[ad]</textarea></td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td>$ad[credits]</td>
	</tr>
	<tr>
		<td>Class: </td>
		<td>".iif($ad['class']=="P","Points","Class $ad[class]")."</td>
	</tr>
	<tr>
		<td>Value: </td>
		<td>".iif($ad[pamount]==0,"Not Set Yet",iif($ad['class']=="P","$ad[pamount] Points","$cursym $ad[pamount]")." - $ad[timed] Seconds")."</td>
	</tr>
	<tr>
		<td>Highlight Color: </td>
		<td>
			".iif($ad['bgcolor']!="","<div style=\"background-color: $ad[bgcolor]\">$ad[bgcolor]</div>","None")."
		</td>
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
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList($ad[country])."</select></td>
	</tr>
	<tr>
		<td>Icon Addon: </td>
		<td>".iif($ad['icon_on']==1,"".iif($ad['icon']!="","<img src=\"adicons/".$ad['icon']."\" />","Yes")." <a href=\"index.php?view=account&ac=edit_icon&type=ptrad&id=".$ad['id']."&".$url_variables."\"><sup>edit</sup></a>","No")."</td>
	</tr>
	<tr>
		<td>Subtitle Addon: </td>
		<td>".iif($ad['subtitle_on']==1,"<input type=\"text\" name=\"subtitle\" value=\"".$ad['subtitle']."\">","No")."</td>
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
			<input type=\"button\" value=\"Delete Ad\" onclick=\"location.href='index.php?view=account&ac=delete_ptrad&id=$id&".$url_variables."'\">
			<input type=\"button\" value=\"Add Credits\" onclick=\"location.href='index.php?view=account&ac=add_credits_ptrad&id=$id&".$url_variables."'\">
		</td>
	</tr>
</table>
</form>
</div>
";
}}

?>
