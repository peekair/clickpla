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
$includes[title]="Manage Link Ads";

if($action == "add") {
	$title=stripslashes(str_replace("\"","",$title));
	$title=stripslashes(str_replace("'","",$title));
	$target=stripslashes(str_replace("\"","",$target));
	$target=stripslashes(str_replace("'","",$target));
	$country=stripslashes(str_replace("\"","",$country));
	$country=stripslashes(str_replace("'","",$country));
	if($title == "") {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://")) {
		$error_msg="You must enter a valid target URL!";
	}
	else if($terms != "on") {
		$error_msg="Your Site Must Not Violate The Terms!";
	}
	else if(is_ad_blocked($target)) {
		$error_msg="Error 382 was returned. Please contact support!";
	}
	else {
		$sql=$Db1->query("INSERT INTO ads SET title='$title', dsub='".time()."', country='".addslashes($country)."', upgrade='".addslashes($premOnly)."', daily_limit='".addslashes($dlimit)."', username='$username', targetban='$targetban', target='$target', active='".iif($settings[ptc_approve]==1,"0","1")."'");
		$Db1->sql_close();
                mail($settings['admin_email'], "New PTC ad at {$settings['site_title']}", "Hello admin,\n\nThere is a new PTC ad at {$settings['site_title']}.");
		header("Location: index.php?view=account&ac=myads&adtype=link&".$url_variables."");
	}
}

if($target=="") {
	$target="http://";
}


$sql=$Db1->query("SELECT * FROM ads WHERE username='$username'");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$linkads.="
	<tr>
		<td>
			".iif($ad['icon_on'] == 1,"<strong title=\"Icon\">I</strong>")."
			".iif($ad['subtitle_on'] == 1,"<strong title=\"Subtitle\">S</strong>")."
			".iif($ad['bgcolor'] != '',"<strong title=\"Highlighting\">H</strong>")."
			".iif($ad['upgrade'] == 1,"<strong title=\"Premium Members Only\">P</strong>")."
		</td>
		<td>&nbsp; <a href=\"index.php?view=account&ac=view_link&id=$ad[id]&".$url_variables."\" title=\"".ucwords(strtolower(stripslashes($ad[title])))."\">".parse_link(ucwords(strtolower(stripslashes($ad[title]))),30)."</a></b></td>
		<td>&nbsp; $ad[credits]</td>
		<td>&nbsp; $ad[views]</td>
		<td>&nbsp; $ad[views_today] / $ad[daily_limit]</td>
		<td>&nbsp; $ad[class]</td><td align=\"center\">
			".iif($ad[active] == 0,"<font color=\"darkblue\">Waiting Approval")."
			".iif($ad[active] == 1,"<font color=\"darkgreen\">Active")."
			".iif($ad[active] == 2,"<font color=\"darkred\">Approval Denied")."
		</font></td><td>&nbsp; $ad[decline]</td>
		<td align=\"center\">
			<a href=\"index.php?view=account&ac=add_credits_link&id=$ad[id]&".$url_variables."\">Add</a>
			".iif($ad[forbid_retract]==0 && $ad['class']!="P" && ($settings[allow_retract] == 1),"&nbsp;&nbsp;&nbsp;<a href=\"index.php?view=account&ac=retract_credits_link&id=$ad[id]&".$url_variables."\">Retract</a>")."
			</td>
	</tr>
	";
	}
}
else {
	$linkads="
		<tr class=\"tableHL2\">
			<td colspan=5 align=\"center\">There Are No Link Ads On Your Account</td>
		</tr>
	";
}

$includes[content].="
<script>
function show_new_form() {
	document.getElementById('new_ad').style.display='';
}
</script>
".iif($thismemberinfo[confirm] == 1,"
<table class=\"ptcList\">
	<tr>
		<th width=50>Addons</th>
		<th width=200>Ad</th>
		<th>Credits</th>
		<th>Clicks</th>
		<th>Today / Limit</th>
		<th>Class</th><th>Status</th>  <th>Decline Msg</th>
		<th>Credit Actions</th>
	</tr>
	$linkads
</table>


<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>


".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."
<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<form action=\"index.php?view=account&ac=myads&adtype=link&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New Link Ad</b>
<table>
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"$title\"></td>
	</tr>
	<tr>
		<td>Target Url: </td>
		<td><input type=\"text\" name=\"target\" value=\"$target\"></td>
	</tr>

<tr>
		<td>PTCBanner Url: </td>
		<td><input type=\"text\" name=\"targetban\" value=\"$targetban\"></td>
	</tr>



	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList()."</select></td>
	</tr>
	<tr>
		<td>Daily Limit: </td>
		<td><input type=\"text\" name=\"dlimit\" value=\"".iif($dlimit == "","0",$dlimit)."\" size=4> <small>0 for no limit</small></td>
	</tr>
	<tr>
		<td>Premium Members Only? </td>
		<td><input type=\"checkbox\" name=\"premOnly\" value=\"1\" ".iif($ad[upgrade] == 1,"checked=\"checked\"")."></td>
	</tr>




	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"checkbox\" name=\"terms\" class=\"checkbox\"> Does Not Violate <a href=\"index.php?view=terms\" target=\"_blank\">Terms</a>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Link\"></td>
	</tr>
</table>
</div>
</form>
</div>")."

";


?>
