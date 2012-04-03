<?
//**VS**//$setting[ptc]//**VE**//

requireAdmin();

//start, epp, sortType, sortOrder, searchStr, searchItem

if($searchStr != "") {
	$searchStr2=explode(" ", $searchStr);
	for($x=0; $x<count($searchStr2); $x++) {
		$conditions.=" ptsuads.$searchItem LIKE '%$searchStr2[$x]%' ";
		if($x < (count($searchStr2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$searchStr&search_by=$searchItem";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM ptsuads ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+$epp;
if($start+$epp > $ttotal) {$end=$ttotal;}


if($sortOrder == "") 	$sortOrder="DESC";
if($sortOrder == "DESC") $newtype="ASC";
if($sortOrder == "ASC") 	$newtype="DESC";

if($sortType == "") 	$sortType="ptsuads.title";


$order[$sortType]="<img src=\"images/"."$sortOrder".".gif\" border=0>";


$sql=$Db1->query("SELECT ptsuads.* FROM ptsuads WHERE ".iif($conditions,"$conditions","1")." ORDER BY $sortType $sortOrder LIMIT $start, $epp");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_link=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
			<tr>
				<td><a href=\"#\" onclick=\"edit_ad($this_link[id])\">".parse_link(ucwords(strtolower(stripslashes($this_link[title]))), $epp).iif($this_link[title] == "","No Title")."</a></td>
				<td><a href=\"index.php?view=admin&ac=edit_user&uname=".$this_link[username]."&s=$s&direct=links&start=$start&type=$sortOrder&orderby=$sortType".iif($search_var,"$search_var")."&".$url_variables."\">$this_link[username]</a></td>
				<td>$this_link[pamount]</td>
				<td>$this_link[credits]</td>
				<td>$this_link[signups] ($this_link[pending])</td>
				<td width=10><input type=\"checkbox\" value=\"1\" onclick=\"tag($this_link[id], this)\" ".iif($this_link[tagged] == 1,"checked=\"checked\"")."></td>
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


".iif($searchStr != "","
<div align=\"right\" style=\"padding: 0 10 0 0px;\">
	$ttotal results found for: <b style=\"color: red\">
		".iif($searchItem=="tagged","Tagged","$searchStr")."
	</b>
</div>
")."

<div align=\"center\" style=\"padding: 3px;\">



<table class=\"tableData\" id=\"manager_table\">
	<tr>
		<th><a href=\"#\" onclick=\"sort_manager('ptsuads.title', '$newtype')\"><b>Title</b> ".$order['ptsuads.title']."</a></th>
		<th><a href=\"#\" onclick=\"sort_manager('ptsuads.username', '$newtype')\"><b>Username</b> ".$order['ptsuads.username']."</a></th>
		<th><a href=\"#\" onclick=\"sort_manager('ptsuads.pamount', '$newtype')\"><b>Value</b> ".$order['ptsuads.pamount']."</a></th>
		<th><a href=\"#\" onclick=\"sort_manager('ptsuads.credits', '$newtype')\"><b>Credits</b> ".$order['ptsuads.credits']."</a></th>
		<th><a href=\"#\" onclick=\"sort_manager('ptsuads.signups', '$newtype')\"><b>Signups</b> ".$order['ptsuads.signups']."</a></th>
		<th width=10></th>
	</tr>
	
		$userslisted
	
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Signup Ads<br />";
	if($ttotal > $epp) {$bc.="[ ";}
	if($start > ($epp-1)) {
		$bstart=$start-$epp;
		$bc.="<a href=\"#\" onclick=\"change_manager_page($bstart)\">Back</a>";
	}
	if(($start > ($epp-1)) && ($start+$epp < $ttotal)) {$bc.=" :: ";}
	if($start+$epp < $ttotal) {
		$start=$start+$epp;
		$bc.=" <a href=\"#\" onclick=\"change_manager_page($start)\">Next</a> ";
	}
	if($ttotal > $epp) {$bc.=" ]";}
}


$includes[content].=$bc."</div>

<div style=\"text-align: right; padding: 0 10 0 0px\">
<input type=\"button\" value=\"View Tagged\" onclick=\"viewTagged()\">
<input type=\"button\" value=\"Refresh\" onclick=\"refresh_manager()\">
<input type=\"button\" value=\"Reset View\" onclick=\"reset_manager()\">
</div>




";

echo $includes[content];

?>
