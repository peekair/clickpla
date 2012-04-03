<?
$includes[title]="Manage Ptp Ads";

//**S**//
if(SETTING_PTP != true) {
	haultscript();
}
else {
	if($action == "add") {
		$title=stripslashes(str_replace("\"","",$title));
		$title=stripslashes(str_replace("'","",$title));
		$target=stripslashes(str_replace("\"","",$target));
		$target=stripslashes(str_replace("'","",$target));
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
			$sql=$Db1->query("INSERT INTO popups SET title='$title', daily_limit='".addslashes($dlimit)."', dsub='".time()."', username='$username', target='$target'");
			$Db1->sql_close();
			header("Location: index.php?view=account&ac=myads&adtype=popups&".$url_variables."");
		}
	}
	if($target=="") {
		$target="http://";
	}
	$sql=$Db1->query("SELECT * FROM popups WHERE username='$username'");
}
//**E**//


if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$popuppopups.="
	<tr>
		<td>&nbsp; <a href=\"index.php?view=account&ac=view_popup&id=$ad[id]&".$url_variables."\" title=\"".ucwords(strtolower(stripslashes($ad[title])))."\">".parse_link(ucwords(strtolower(stripslashes($ad[title]))),30)."</a></b></td>
		<td>&nbsp; $ad[credits]</td>
		<td>&nbsp; $ad[views]</td>
		<td>&nbsp; $ad[views_today] / $ad[daily_limit]</td>
		<td align=\"center\">
			".iif($ad[active] == 0,"<font color=\"darkblue\">Waiting Approval")."
			".iif($ad[active] == 1,"<font color=\"darkgreen\">Active")."
			".iif($ad[active] == 2,"<font color=\"darkred\">Approval Denied")."
		</font></td>




<td>&nbsp; $ad[decline]</td>







		<td align=\"right\"><a href=\"index.php?view=account&ac=add_credits_popup&id=$ad[id]&".$url_variables."\">Add Credits</a></td>
		<td align=\"right\"><a href=\"index.php?view=account&ac=retract_credits_ptp&id=$ad[id]&".$url_variables."\">Retract Credits</a></td>
	</tr>
	";
	}
}
else {
	$popuppopups="
		<tr class=\"tableHL2\">
			<td colspan=5 align=\"center\">There Are No PTP Ads On Your Account</td>
		</tr>
	";
}

$includes[content].="
<script>
function show_new_form() {
	document.getElementById('new_ad').style.display='';
}
</script>
<table class=\"ptcList\">

	<tr>
		<th>Ad</th>
		<th>Credits</th>
		<th>Clicks</th>
		<th>Today / Limit</th>
                <th>Status</th>  
                <th>Decline Msg</th>
		<th>Add Credits</th>
		<th>Retract Credits</th>

	</tr>
	$popuppopups
</table>

<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>

".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."
<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<form action=\"index.php?view=account&ac=myads&adtype=popups&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New PTP Ad</b>
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
		<td>Daily Limit: </td>
		<td><input type=\"text\" name=\"dlimit\" value=\"".iif($dlimit == "","0",$dlimit)."\" size=4> <small>0 for no limit</small></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
			<input type=\"checkbox\" name=\"terms\" class=\"checkbox\"> Does Not Violate <a href=\"index.php?view=terms\" target=\"_blank\">Terms</a>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Popup\"></td>
	</tr>
</table>
</div>
</form>
</div>

";


?>