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
$includes[title]="Manage Featured Links";


if($action == "add") {
	$title=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$title))));
	$target=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$target))));
	$flink=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$flink))));

	if((!isset($title)) || ($title=="")) {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://")) {
		$error_msg="You must enter a valid target URL!";
	}
	else if($terms != "on") {
		$error_msg="Your Featured Must Not Violate The Terms!";
	}
	else if(is_ad_blocked($target)) {
		$error_msg="Error 382 was returned. Please contact support!";
	}
	else {
		$sql=$Db1->query("INSERT INTO flinks SET title='$title', dsub='".time()."', username='$username', target='$target'");
		$Db1->sql_close();
                mail($settings['admin_email'], "New featured link ad at {$settings['site_title']}", "Hello admin,\n\nThere is a new featured link ad at {$settings['site_title']}.");
		header("Location: index.php?view=account&ac=myads&adtype=flink&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT * FROM flinks WHERE username='$username'");
if($Db1->num_rows() != 0) {
	while($ad=$Db1->fetch_array($sql)) {
	$flinkads.="
	<tr>
		<td>&nbsp; <a href=\"index.php?view=account&ac=view_flink&id=$ad[id]&".$url_variables."\">".stripslashes($ad[title])."</a></b></td>
		<td>&nbsp; ".iif($ad[dend]>time(),date('M d, Y', time(0,0,$ad[dend],1,1,1970)),"Not Active")."</td>
		<td>&nbsp; $ad[views]</td>
		<td>&nbsp; $ad[views_today]</td>
		<td>&nbsp; $ad[clicks]</td>
		<td>&nbsp; ".round(@($ad[clicks]/$ad[views]*100),3)."%</td>
		<td align=\"right\"><a href=\"index.php?view=account&ac=add_credits_flink&id=$ad[id]&".$url_variables."\">Add Time</a></td>
	</tr>
	";
	}
}
else {
	$flinkads="
		<tr class=\"tableHL2\">
			<td colspan=7 align=\"center\">You Have Not Added Any Featured Links!</td>
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
		<th>Expiration</th>
		<th>Views</th>
		<th>Today</th>
		<th>Clicks</th>
		<th>%</th>
		<th>Add Time</th>
	</tr>
	$flinkads
</table>

<div align=\"right\" style=\"padding: 4 0 0 0px;\">
	<input type=\"button\" onclick=\"show_new_form()\" value=\"Create New Ad\">
</div>


".iif(isset($error_msg),"<script>alert('$error_msg');</script>")."
<div align=\"center\" style=\"display: none\" id=\"new_ad\">
<form action=\"index.php?view=account&ac=myads&adtype=flink&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<div style=\" width: 300px;\">
<b>New Featured Link</b>
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
		<td colspan=2 align=\"center\">
			<input type=\"checkbox\" name=\"terms\" class=\"checkbox\"> Does Not Violate <a href=\"index.php?view=terms\" target=\"_blank\">Terms</a>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Featured Link\"></td>
	</tr>
</table>
</div>
</form>
</div>")."

";

?>
