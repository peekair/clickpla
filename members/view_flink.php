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
$includes[title]="View Featured Link";

$sql=$Db1->query("SELECT * FROM flinks WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

if($ad[username]!=$username) {
	$includes[content]="You do not have permission to this area!";
}
else {
	$includes[content]="
<div style=\"text-align: right\"><a href=\"index.php?view=account&ac=myads&adtype=flink&".$url_variables."\">Back To Ad Manager</a></div>
<div align=\"center\">
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
		<td>Highlight Color: </td>
		<td>
			".iif($ad['bgcolor']!="","<div style=\"background-color: $ad[bgcolor]\">$ad[bgcolor]</div>","None")."
		</td>
	</tr>
	<tr>
		<td>Marquee Scroll?</td>
		<td>
			".iif($ad['marquee']==1,"Yes","No")."
		</td>
	</tr>
	<tr>
		<td>Views: </td>
		<td>$ad[views]</td>
	</tr>
	<tr>
		<td>Clicks: </td>
		<td>$ad[clicks]</td>
	</tr>
	<tr>
		<td>Clicks Today: </td>
		<td>$ad[clicks_today]</td>
	</tr>
	<tr>
		<td>Expiration: </td>
		<td>".iif($ad[dend]>time(),date('M d, Y', mktime(0,0,$ad[dend],1,1,1970)),"Not Active")."</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"button\" value=\"Delete Featured Link\" onclick=\"location.href='index.php?view=account&ac=delete_flink&id=$id&".$url_variables."'\">
			<input type=\"button\" value=\"Extend Time\" onclick=\"location.href='index.php?view=account&ac=add_credits_flink&id=$id&".$url_variables."'\">
		</td>
	</tr>
</table>
</div>
";
}

?>
