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
$includes[title]="Manage Surf Sites";
//**VS**//$setting[se]//**VE**//
//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO surf_sites SET 
			title='$title', 
			dsub='".time()."', 
			username='$user',
			credits='$credits', 
			target='$target',
			forbid_retract='$forbid_retract'
		");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=surf_sites&".$url_variables."");
}


$thePermission=6;
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=surf_sites&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" surf_sites.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM surf_sites ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="surf_sites.title";


if($orderby == "surf_sites.id") {$ordernum=1;}
if($orderby == "surf_sites.title") {$ordernum=2;}
if($orderby == "surf_sites.username") {$ordernum=3;}
if($orderby == "surf_credits") {$ordernum=5;}
if($orderby == "surf_sites.views") {$ordernum=6;}
if($orderby == "surf_sites.views_today") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT surf_sites.* FROM surf_sites WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_surf_site=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td NOWRAP=\"NOWRAP\">$this_surf_site[id]</td>
					<td NOWRAP=\"NOWRAP\"><a href=\"$this_surf_site[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_surf_site&id=".$this_surf_site[id]."&s=$s&direct=surf_sites&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">*".parse_link(ucwords(strtolower(stripslashes($this_surf_site[title]))), 25)."</a></td>
					<td NOWRAP=\"NOWRAP\"><a href=\"admin.php?view=admin&ac=edit_user&id=".$this_surf_site[userid]."&s=$s&direct=surf_sites&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_surf_site[username]</a></td>
					<td NOWRAP=\"NOWRAP\">$this_surf_site[credits]</td>
					<td NOWRAP=\"NOWRAP\">$this_surf_site[views]</td>
					<td NOWRAP=\"NOWRAP\">$this_surf_site[views_today]</td>
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
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=surf_sites&search=1&".$url_variables."\" method=\"post\">
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

<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100%\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"1\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td NOWRAP><b><a href=\"admin.php?view=admin&ac=surf_sites&orderby=surf_sites.id&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Id ".$order[1]."</a></b></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=surf_sites&orderby=surf_sites.title&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Title</b> ".$order[2]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=surf_sites&orderby=surf_sites.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[3]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=surf_sites&orderby=surf_credits&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Credits</b> ".$order[5]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=surf_sites&orderby=surf_sites.views&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Views</b> ".$order[6]."</a></td>
					<td NOWRAP><a href=\"admin.php?view=admin&ac=surf_sites&orderby=surf_sites.views_today&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Today</b> ".$order[7]."</a></td>
				</tr>
				
					$userslisted
				
			</table>
		</td>
	</tr>
</table>
";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Surf Sites<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=surf_sites&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=surf_sites&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


<br /><br />


<div align=\"center\">
<form action=\"admin.php?view=admin&ac=surf_sites&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" name=\"form\">
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
