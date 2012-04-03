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
$includes[title]="Manage Featured Ads";


if($action == "add") {
	$title=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$title))));
	$target=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$target))));
	$fad1=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$fad1))));

	if((!isset($title)) || ($title=="")) {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://")) {
		$error_msg="You must enter a valid target URL!";
	}
	else if((!isset($fad1)) || ($fad1=="")) {
		$error_msg="You must enter a valid ad!";
	}
	else if($terms != "on") {
		$error_msg="Your Featured Must Not Violate The Terms!";
	}
	else if(is_ad_blocked($target)) {
		$error_msg="Error 382 was returned. Please contact support!";
	}
	else {
		$sql=$Db1->query("INSERT INTO fads SET title='$title', daily_limit='".addslashes($dlimit)."', dsub='".time()."', username='$username', description='".addslashes(htmlentities($fad1))."', target='$target'");
		$Db1->sql_close();
                mail($settings['admin_email'], "New featured ad at {$settings['site_title']}", "Hello admin,\n\nThere is a new featured ad at {$settings['site_title']}.");

		header("Location: index.php?view=account&ac=myads&adtype=fad&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT * FROM fads WHERE username='$username'");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$fadads.="
	<tr>
		<td>&nbsp; <a href=\"index.php?view=account&ac=view_fad&id=$ad[id]&".$url_variables."\">".stripslashes($ad[title])."</a></b></td>
		<td>&nbsp; $ad[credits]</td>
		<td>&nbsp; $ad[views]</td>
		<td>&nbsp; $ad[views_today] / $ad[daily_limit]</td>
		<td>&nbsp; $ad[clicks]</td>
		<td>&nbsp; ".round(@($ad[clicks]/$ad[views]*100),3)."%</td>
		<td align=\"center\">
			<a href=\"index.php?view=account&ac=add_credits_fad&id=$ad[id]&".$url_variables."\">Add Credits</a>
			".iif($ad[forbid_retract]==0 && ($settings[allow_retract] == 1),"&nbsp;&nbsp;&nbsp;<a href=\"index.php?view=account&ac=retract_credits_fad&id=$ad[id]&".$url_variables."\">Retract</a>")."
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
	$fadads="
		<tr class=\"tableHL2\">
			<td colspan=6 align=\"center\">You Have Not Added Any Featured Ads!</td>
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
		<th width=150>Ad</th>
		<th>Credits</th>
		<th>Views</th>
		<th>Today / Limit</th>
		<th>Clicks</th>
		<th>%</th>
		<th>Credit Actions</th>
		<th>Status</th>
		  <th>Decline Msg</th>
		
	</tr>
	$fadads
</table>

<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>

<script language=\"JavaScript\">
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
	else 
		countfield.value = maxlimit - field.value.length;
}
</script>



".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."
<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<form action=\"index.php?view=account&ac=myads&adtype=fad&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New Featured Ad</b>
<table>
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"$title\" maxlength=$settings[fad_title_limit] onKeyDown=\"textCounter(this.form.title,this.form.titlecount,$settings[fad_title_limit]);\" onKeyUp=\"textCounter(this.form.title,this.form.titlecount,$settings[fad_title_limit]);\">
			<input type=\"text\" name=\"titlecount\" size=2 maxlength=2 value=\"$settings[fad_title_limit]\">
		</td>
	</tr>
	<tr>
		<td>Target Url: </td>
		<td><input type=\"text\" name=\"target\" value=\"$target\"><br /><small>URL must include <i style=\"color: blue\">http://</i></small></td>
	</tr>
	<tr>
		<td>Featured Ad: </td>
		<td><textarea name=\"fad1\" cols=30 rows=5 maxlength=$settings[fad_title_limit] onKeyDown=\"textCounter(this.form.fad1,this.form.desccount,$settings[fad_desc_limit]);\" onKeyUp=\"textCounter(this.form.fad1,this.form.desccount,$settings[fad_desc_limit]);\">$fad1</textarea>
			<div align=\"center\">
			<input type=\"text\" name=\"desccount\" size=2 maxlength=2 value=\"$settings[fad_desc_limit]\"> Characters Left
			</div>
		</td>
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
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Featured Ad\"></td>
	</tr>
</table>
</div>
</form>
</div>")."

";

?>
