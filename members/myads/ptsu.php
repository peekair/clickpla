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
$includes[title]="Manage Paid To Signup Offers";

if($action == "add") {
	$title=stripslashes(str_replace("\"","",$title));
	$title=stripslashes(str_replace("'","",$title));
	$target=stripslashes(str_replace("\"","",$target));
	$target=stripslashes(str_replace("'","",$target));
	$country=stripslashes(str_replace("\"","",$country));
	$country=stripslashes(str_replace("'","",$country));
   	$subtitle=stripslashes(str_replace("\"","",$subtitle));
	$subtitle=stripslashes(str_replace("'","",$subtitle));
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
		$sql=$Db1->query("INSERT INTO ptsuads SET title='$title', country='".addslashes($country)."', upgrade='".addslashes($premOnly)."', dsub='".time()."', username='$username', target='$target', active='".iif($settings[ptsu_require_act]==1,"0","1")."', class='".$settings[ptsudefault]."', pamount='".$settings[ptsu_value]."', subtitle_on='1', subtitle='$subtitle'");
		$Db1->sql_close();
                mail($settings['admin_email'], "New PTSU ad at {$settings['site_title']}", "Hello admin,\n\nThere is a new PTSU ad at {$settings['site_title']}.");

		header("Location: index.php?view=account&ac=myads&adtype=ptsu&".$url_variables."");
		exit;
	}
}

if($target=="") {
	$target="http://";
}


$sql=$Db1->query("SELECT * FROM ptsuads WHERE username='$username'");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$linkads.="
	<tr>
		<td>
			".iif($ad['icon_on'] == 1,"<strong title=\"Icon\">I</strong>")."
			".iif($ad['bgcolor'] != '',"<strong title=\"Highlighting\">H</strong>")."
			".iif($ad['upgrade'] == 1,"<strong title=\"Premium Members Only\">P</strong>")."
		</td>
		<td>&nbsp; <a href=\"index.php?view=account&ac=view_ptsu&id=$ad[id]&".$url_variables."\" title=\"".ucwords(strtolower(stripslashes($ad[title])))."\">".parse_link(ucwords(strtolower(stripslashes($ad[title]))),30)."</a></b></td>
		<td>&nbsp; $ad[credits]</td>
		<td>&nbsp; $ad[signups]</td>
		<td>&nbsp; $ad[signups_today]</td>
		<td align=\"center\">
			<a href=\"index.php?view=account&ac=add_credits_ptsu&id=$ad[id]&".$url_variables."\">Add</a>
			".iif($ad[forbid_retract]==0 && $ad['class']!="P" && ($settings[allow_retract] == 1),"&nbsp;&nbsp;&nbsp;<a href=\"index.php?view=account&ac=retract_credits_ptsu&id=$ad[id]&".$url_variables."\">Retract</a>")."
			</td>
	</tr>
	";
	}
}
else {
	$linkads="
		<tr class=\"tableHL2\">
			<td colspan=5 align=\"center\">There are no Signup Offers on your account</td>
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
		<th width=50></th>
		<th width=200>Ad</th>
		<th>Credits</th>
		<th>Signups</th>
		<th>Today</th>
		<th>Credit Actions</th>
	</tr>
	$linkads
</table>

<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>

".iif($settings["ptsu_mode"] == 2,"
<hr>
<strong>Please Note: </strong> Advertiser signup approval is currently enabled. This means that you must approve or deny any signups for your PTSU program. Any signups that are not approved or denied after ".$settings[ptsuAdvTimeout]." days will automatically be approved with no option to dispute validity. Also keep in mind, if you purposely deny signups that are valid, you will lose all your remaining credits without a refund and you may lose your account.
")."


".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."

<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<hr>
<form action=\"index.php?view=account&ac=myads&adtype=ptsu&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New Signup Offer</b>
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
					<td>Description:</td>
					<td class=\"form_row_value\"><textarea cols=\"35\" rows=\"4\"  value=\"$subtitle\" name=\"subtitle\"></textarea></td>
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
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Offer\"></td>
	</tr>
</table>
</div>
</form>
</div>
")."

";

if($action == "approve" && ($status == 1 || $status == 4)) {
	$sql=$Db1->query("SELECT * FROM ptsu_log WHERE id='".mysql_real_escape_string($id)."' and status='2'");
	$temp=$Db1->fetch_array($sql);

//echo "<br /><br /><br /> $id : $temp[username] : $temp[ptsu_id]<br />";

	$sql2=$Db1->query("SELECT * FROM ptsuads WHERE id='$temp[ptsu_id]' and username='$username'");
	if($Db1->num_rows() > 0) {
		if($status == 1) {
			$Db1->query("UPDATE ptsu_log SET status='1' WHERE id='".$id."'");
			$Db1->query("UPDATE user SET balance=balance+".$temp[pamount]." WHERE username='".$temp[username]."'");
			$Db1->query("UPDATE ptsuads SET pending=pending-1 WHERE id='".$temp[ptsu_id]."'");
			$Db1->query("UPDATE stats SET signups=signups+1 WHERE date='$today_date'");
		}

		if($status == 4) {
			$Db1->query("UPDATE ptsu_log SET status='4' WHERE id='".$id."'");
			$Db1->query("UPDATE ptsuads SET pending=pending-1, credits=credits+1 WHERE id='".$temp[ptsu_id]."'");
		}

		$Db1->sql_close();
		header("Location: index.php?view=account&ac=myads&adtype=ptsu&".$url_variables."");
		exit;
	}
	else {
		echo "failed!";
	}
}


$sql=$Db1->query("SELECT ptsu_log.*, ptsuads.title, ptsuads.target FROM ptsu_log, ptsuads WHERE ptsu_log.status='2' and ptsuads.id=ptsu_log.ptsu_id and ptsuads.username='$username' ORDER BY ptsu_log.ptsu_id");
$total=$Db1->num_rows();
for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
	$list.="
		<div class=\"borderBox\" id=\"approve_ad_main".$temp[id]."\">
			<div style=\"float: right;\">
				<a href=\"index.php?view=account&ac=myads&adtype=ptsu&id=$temp[id]&action=approve&status=1&".$url_variables."\"><b>Approve</b></a> &nbsp;&nbsp;&nbsp;
				<a href=\"index.php?view=account&ac=myads&adtype=ptsu&id=$temp[id]&action=approve&status=4&".$url_variables."\"><b>Deny</b></a>
			</div>
			<a href=\"$temp[target]\" target=\"_blank\">$temp[title]</a>
			<div id=\"approve_ad".$temp[id]."\">
				Username: $temp[username]<br />
				<div style=\"height: 150px; overflow: auto; border: 1px solid #c8c8c8; background-color: white; text-align: left; padding: 5 5 5 5px; color: black\">
					<b>Userid Used: </b> $temp[userid]<br />
					".nl2br($temp[welcome_email])."
				</div>
			</div>
		</div>
	";
}

if($total > 0) {
	$includes[content].="
<hr>
	<b>Signups Pending Approval</b>
	$list
	";
}

?>
