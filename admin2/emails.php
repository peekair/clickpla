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
$includes[title]="Email Ads Manager";
//**VS**//$setting[ptr]//**VE**//
//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO emails SET
			title='".htmlentities($title)."',
			target='$target',
			username='$user',
			credits='$credits',
			country='$country',
			views='$views',
			description='".addslashes($description)."',
			forbid_retract='$forbid_retract'
		");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=emails&".$url_variables."");
}

if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=emails&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type");
	exit;
}


if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" emails.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM emails ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="emails.credits";


if($orderby == "emails.id") {$ordernum=1;}
if($orderby == "emails.title") {$ordernum=2;}
if($orderby == "emails.username") {$ordernum=3;}
if($orderby == "emails.dsub") {$ordernum=4;}
if($orderby == "emails.credits") {$ordernum=5;}
if($orderby == "emails.views") {$ordernum=6;}
if($orderby == "emails.views_today") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT emails.* FROM emails WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_email=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_email[id]</td>
					<td><a href=\"$this_email[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_email&id=".$this_email[id]."&s=$s&direct=emails&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."\">*".ucwords(strtolower(stripslashes($this_email[title])))."</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_email[username]."&s=$s&direct=emails&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."\">$this_email[username]</a></td>
					<td>$this_email[credits]</td>
					<td>$this_email[views]</td>
					<td>$this_email[views_today]</td>
				</tr>
";
	}
}
else {
	$userslisted="
			<tr>
				<td colspan=7 align=center class=\"tableHL2\">No Results!</td>
			</tr>
	";
}
	$includes[content].="
<div align=\"left\">
<a href=\"admin.php?view=admin&ac=actemail&".$url_variables."\"><font size=\"4\">Activate ads</a></font><br>

<a href=\"admin.php?view=admin&ac=purgeemails&".$url_variables."\"><font size=\"4\">Purge Old Emails</a></font></div><br><div align=\"center\">
<form action=\"admin.php?view=admin&ac=emails&search=1\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>

<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=emails&orderby=emails.id&type=$newtype".iif($search_var,"$search_var")."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=emails&orderby=emails.title&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=emails&orderby=emails.username&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Username</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=emails&orderby=emails.credits&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Credits</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=emails&orderby=emails.views&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Views</b> ".$order[6]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=emails&orderby=emails.views_today&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Today</b> ".$order[7]."</a></th>
	</tr>
	
		$userslisted
	
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type emails<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=emails&start=$bstart&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=emails&start=$start&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


<div align=\"center\">
<form action=\"admin.php?view=admin&ac=emails&action=add&".$url_variables."\" method=\"post\">
<table cellspacing=\"1\" cellpadding=\"0\" border=0>
				<tr>
					<td colspan=2 align=\"center\"><b>New Email Ad</b></td>
				</tr>
				<tr>
					<td>Title:</td>
					<td><input type=\"text\" name=\"title\"></td>
				</tr>
				<tr>
					<td>Target Url:</td>
					<td><input type=\"text\" name=\"target\"></td>
				</tr>
				<tr>
					<td>Username:</td>
					<td><input type=\"text\" name=\"user\"></td>
				</tr>
	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList()."</select></td>
	</tr>
				<tr>
					<td>Credits:</td>
					<td><input type=\"text\" name=\"credits\"></td>
				</tr>
				<tr>
					<td>Description:</td>
					<td><textarea name=\"description\" cols=20 rows=4></textarea></td>
				</tr>
	<tr>
		<td colspan=2>Forbid Credit Retraction: <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"></td>
	</tr>
				<tr>
					<td colspan=2 align=\"center\">
						<input type=\"submit\" value=\"Save\">
					</td>
				</tr>
</table>
</form>
</div>

";
//**E**//
?>
