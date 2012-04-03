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
$includes[title]="Manage Exchange Sites";
//**VS**//$setting[ce]//**VE**//
//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO xsites SET 
			title='$title', 
			dsub='".time()."', 
			username='$user',
			credits='$credits', 
			country='$country',
			target='$target',
			forbid_retract='$forbid_retract',
			active='$active'
		");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=xsites&".$url_variables."");
}


$thePermission=6;
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=xsites&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" xsites.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM xsites ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="xsites.title";


if($orderby == "xsites.id") {$ordernum=1;}
if($orderby == "xsites.title") {$ordernum=2;}
if($orderby == "xsites.username") {$ordernum=3;}
if($orderby == "credits") {$ordernum=5;}
if($orderby == "xsites.views") {$ordernum=6;}
if($orderby == "xsites.views_today") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT xsites.* FROM xsites WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_xsite=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_xsite[id]</td>
					<td><a href=\"$this_xsite[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_xsite&id=".$this_xsite[id]."&s=$s&direct=xsites&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">*".parse_link(ucwords(strtolower(stripslashes($this_xsite[title]))), 25)."</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_xsite[username]."&s=$s&direct=xsites&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_xsite[username]</a></td>
					<td>$this_xsite[credits]</td>
					<td>$this_xsite[views]</td>
					<td>$this_xsite[views_today]</td>
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
<a href=\"admin.php?view=admin&ac=actxsurf&".$url_variables."\"><font size=\"4\">Activate Xsites</a></font><br><a href=\"admin.php?view=admin&ac=purgexsites&".$url_variables."\"><font size=\"4\">Purge Old Click Exchange Ads</a></font></div><br><br>
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=xsites&search=1&".$url_variables."\" method=\"post\">
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
		<th><b><a href=\"admin.php?view=admin&ac=xsites&orderby=xsites.id&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=xsites&orderby=xsites.title&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=xsites&orderby=xsites.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=xsites&orderby=credits&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Credits</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=xsites&orderby=xsites.views&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Views</b> ".$order[6]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=xsites&orderby=xsites.views_today&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Today</b> ".$order[7]."</a></th>
	</tr>
	
		$userslisted
	
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Exchange Sites<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=xsites&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=xsites&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


<br /><br />


<div align=\"center\">
<form action=\"admin.php?view=admin&ac=xsites&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" name=\"form\">
<b>New Site</b>
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
		<td><input type=\"text\" name=\"credits\" value=\"0\"></td>
	</tr>
	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList()."</select></td>
	</tr>
	<tr>
		<td>Verified?: </td>
		<td><select name=\"active\">
			<option value=\"1\">Yes
			<option value=\"0\">No
		</select></td>
	</tr>
	<tr>
		<td colspan=2>Forbid Credit Retraction: <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Site\"></td>
	</tr>
</table>
</form>
</div>

";
//**E**//
?>
