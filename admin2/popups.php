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
$includes[title]="Manage Paid To Promote Ads";
//**VS**//$setting[ptp]//**VE**//
//**S**//
if(SETTING_PTP != true) {
	haultscript();
}
if($action == "add") {
		$sql=$Db1->query("INSERT INTO popups SET 
			title='$title', 
			dsub='".time()."', 
			username='$user',
			credits='$credits', 
			target='$target',
			forbid_retract='$forbid_retract'");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=popups&".$url_variables."");
}


$thePermission=6;
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=popups&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" popups.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM popups ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="popups.title";


if($orderby == "popups.id") {$ordernum=1;}
if($orderby == "popups.title") {$ordernum=2;}
if($orderby == "popups.username") {$ordernum=3;}
if($orderby == "popups.pamount") {$ordernum=4;}
if($orderby == "popups.credits") {$ordernum=5;}
if($orderby == "popups.views") {$ordernum=6;}
if($orderby == "popups.timed") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT popups.* FROM popups WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_popup=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_popup[id]</td>
					<td><a href=\"$this_popup[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_popup&id=".$this_popup[id]."&s=$s&direct=popups&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">*".parse_link(ucwords(strtolower(stripslashes($this_popup[title]))), 25)."</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_popup[username]."&s=$s&direct=popups&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_popup[username]</a></td>
					<td>$this_popup[credits]</td>
					<td>$this_popup[views]</td>
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
<a href=\"admin.php?view=admin&ac=actptp&".$url_variables."\"><font size=\"4\">Activate ads</a></font>
<br>
<a href=\"admin.php?view=admin&ac=purgeptp&".$url_variables."\"><font size=\"4\">Purge ads</a></font></div><br>
	
	
	
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=popups&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>

<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=popups&orderby=popups.id&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=popups&orderby=popups.title&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=popups&orderby=popups.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=popups&orderby=popups.credits&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Credits</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=popups&orderby=popups.views&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Views</b> ".$order[6]."</a></th>
	</tr>
	
		$userslisted
	
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Popups<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=popups&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=popups&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


<br /><br />


<div align=\"center\">
<form action=\"admin.php?view=admin&ac=popups&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" name=\"form\">
<b>New Popup Ad</b>
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
		<td>Username: </td>
		<td><input type=\"text\" name=\"user\" value=\"$username\"></td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td><input type=\"text\" name=\"credits\" value=\"0\" onkeyup=\"calculatecost()\"></td>
	</tr>
	<tr>
		<td colspan=2>Forbid Credit Retraction: <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Popup\"></td>
	</tr>
</table>
</form>
</div>

";
//**E**//
?>
