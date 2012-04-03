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
$includes[title]="Manage Email Ads";


if($action == "add") {
	$title=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$title))));
	$target=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$target))));
	$email1=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$email1))));
	$country=stripslashes(str_replace("\"","",$country));
	$country=stripslashes(str_replace("'","",$country));

	if((!isset($title)) || ($title=="")) {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://")) {
		$error_msg="You must enter a valid target URL!";
	}
	else if((!isset($email1)) || ($email1=="")) {
		$error_msg="You must enter a valid ad!";
	}
	else if($terms != "on") {
		$error_msg="Your Featured Must Not Violate The Terms!";
	}
	else if(is_ad_blocked($target)) {
		$error_msg="Error 382 was returned. Please contact support!";
	}
	else {
			$sql=$Db1->query("INSERT INTO emails SET title='$title', country='".addslashes($country)."', upgrade='".addslashes($premOnly)."', daily_limit='".addslashes($dlimit)."', dsub='".time()."', username='$username', description='".addslashes(htmlentities($email1))."', target='$target', active='".iif($settings[ptre_approve]==1,"0","1")."'");
		$Db1->sql_close();
                mail($settings['admin_email'], "New email ad at {$settings['site_title']}", "Hello admin,\n\nThere is a new email ad at {$settings['site_title']}.");

		header("Location: index.php?view=account&ac=myads&adtype=emails&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT * FROM emails WHERE username='$username'");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$emailads.="
	<tr>
		<td width=\"140\">&nbsp; <a href=\"index.php?view=account&ac=view_email&id=$ad[id]&".$url_variables."\">".stripslashes($ad[title])."</a></b></td>
		<td>&nbsp; $ad[credits]</td>
		<td>&nbsp; $ad[views]</td>
		<td>&nbsp; $ad[views_today] / $ad[daily_limit]</td><td>$ad[decline]</td>
<td align=\"center\">
			".iif($ad[active] == 0,"<font color=\"darkblue\">Waiting Approval")."
			".iif($ad[active] == 1,"<font color=\"darkgreen\">Active")."
			".iif($ad[active] == 2,"<font color=\"darkred\">Approval Denied")."
		</font></td> 
		<td align=\"center\">
			<a href=\"index.php?view=account&ac=add_credits_email&id=$ad[id]&".$url_variables."\">Add Credits</a>
			".iif($ad[forbid_retract]==0 && ($settings[allow_retract] == 1),"&nbsp;&nbsp;&nbsp;<a href=\"index.php?view=account&ac=retract_credits_email&id=$ad[id]&".$url_variables."\">Retract</a>")."
		</td>
	</tr>
	";
	}
}
else {
	$emailads="
		<tr class=\"tableHL2\">
			<td colspan=6 align=\"center\">You Have Not Added Any Email Ads!</td>
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
                <th>Decline Msg</th>
                <th>Status</th>
		<th>Credit Actions</th>

	</tr>
	$emailads
</table>


<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>



".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."
<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<form action=\"index.php?view=account&ac=myads&adtype=emails&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New Email Ad</b>
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
		<td>Email Ad:<br /><small>No Html</small></td>
		<td><textarea name=\"email1\" cols=30 rows=5>$email1</textarea></td>
	</tr>
	<tr>
		<td>Daily Limit: </td>
		<td><input type=\"text\" name=\"dlimit\" value=\"".iif($dlimit == "","0",$dlimit)."\" size=4> <small>0 for no limit</small></td>
	</tr>
	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList()."</select></td>
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
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Email Ad\"></td>
	</tr>
</table>
</div>
</form>
</div>")."

";

?>
