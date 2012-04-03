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
$includes[title]="Manage Featured Banner Ads";


if($action == "add") {
	$title=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$title))));
	$target=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$target))));
	$banner=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$banner))));

	if((!isset($title)) || ($title=="")) {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://") || (substr_count($target,"http") == 0)) {
		$error_msg="You must enter a valid target URL!";
	}
	else if((!isset($banner)) || ($banner=="") || ($banner=="http://") || (substr_count($banner,"http") == 0)) {
		$error_msg="You must enter a valid featured banner URL!";
	}
	else if(is_html($banner) == true) {
		$error_msg="HTML was detected in the banner URL! You must enter only the banner image URL!";
	}
	else if(is_html($target) == true) {
		$error_msg="HTML was detected in the target URL! You must enter only the URL, No HTML is allowed!!";
	}
	else if($terms != "on") {
		$error_msg="Your featured banner must not violate the terms!";
	}
	else if(is_ad_blocked($target)) {
		$error_msg="Error 382 was returned. Please contact support!";
	}
	else {
		$sql=$Db1->query("INSERT INTO fbanners SET 
			title='$title', 
			dsub='".time()."', 
			username='$username', 
			daily_limit='".addslashes($dlimit)."',
			banner='$banner', 
			target='$target'");
		$Db1->sql_close();
                mail($settings['admin_email'], "New featured banner at {$settings['site_title']}", "Hello admin,\n\nThere is a new featured banner at {$settings['site_title']}.");
		header("Location: index.php?view=account&ac=myads&adtype=fbanner&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT * FROM fbanners WHERE username='$username'");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$bannerads.="
	<tr>
		<td>&nbsp; <a href=\"index.php?view=account&ac=view_fbanner&id=$ad[id]&".$url_variables."\">".stripslashes($ad[title])."</a></b></td>
		<td>&nbsp; $ad[credits]</td>
		<td>&nbsp; $ad[views]</td>
		<td>&nbsp; $ad[views_today] / $ad[daily_limit]</td>
		<td>&nbsp; $ad[clicks]</td>
		<td>&nbsp; ".round(@($ad[clicks]/$ad[views]*100),3)."%</td>
		<td align=\"center\">
			<a href=\"index.php?view=account&ac=add_credits_fbanner&id=$ad[id]&".$url_variables."\">Add Credits</a>
			".iif($ad[forbid_retract]==0 && ($settings[allow_retract] == 1),"&nbsp;&nbsp;&nbsp;<a href=\"index.php?view=account&ac=retract_credits_fbanner&id=$ad[id]&".$url_variables."\">Retract</a>")."
			</td>
				<td align=\"center\">
			".iif($ad[active] == 0,"<font color=\"darkblue\">Waiting Approval")."
			".iif($ad[active] == 1,"<font color=\"darkgreen\">Active")."
			".iif($ad[active] == 2,"<font color=\"darkred\">Approval Denied")."
		</font>
		</td>
		<td>&nbsp; $ad[decline]</td>
	</tr>
	";
	}
}
else {
	$bannerads="
		<tr class=\"tableHL2\">
			<td colspan=7 align=\"center\">You Have Not Added Any Featured Banner Ads!</td>
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
		<th>Ad</th>
		<th>Credits</th>
		<th>Views</th>
		<th>Today / Limit</th>
		<th>Clicks</th>
		<th>%</th>
		<th>Credit Actions</th>
		<th>Status</th>
		<th>Decline Msg</th>
		
	</tr>
	$bannerads
</table>

<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>

".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."
<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<form action=\"index.php?view=account&ac=myads&adtype=fbanner&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New Featured Banner Ad</b>
<table>
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"".htmlentities(stripslashes($title))."\"></td>
	</tr>
	<tr>
		<td>Target Url: </td>
		<td><input type=\"text\" name=\"target\" value=\"".htmlentities(stripslashes($target))."\"></td>
	</tr>
	<tr>
		<td>Featured Banner Url: </td>
		<td><input type=\"text\" name=\"banner\" value=\"".htmlentities(stripslashes($banner))."\"></td>
	</tr>
	<tr>
		<td>Daily Limit: </td>
		<td><input type=\"text\" name=\"dlimit\" value=\"".iif($dlimit == "","0",$dlimit)."\" size=4> <small>0 for no limit</small></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"checkbox\" name=\"terms\" class=\"checkbox\"> Does Not Violate <a href=\"index.php?view=terms\" target=\"_blank\">Terms</a>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Featured Banner\"></td>
	</tr>
</table>
</div>
</form>
</div>")."

";

?>
