<?
$includes[title]="Site footprint";

$lpp=15;

//**S**//
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=footprints&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		if($search_by != "dsub") $conditions.=" footprints.$search_by LIKE '%$search_str2[$x]%' ";
		else {
			$temp1=explode("/",$search_str);
			$timestart=mktime(0,0,0,$temp1[1],$temp1[0],$temp1[2]);
			$timeend=mktime(0,0,0,$temp1[1],($temp1[0]+1),$temp1[2]);
			$conditions.=" (footprints.dsub>$timestart and footprints.dsub<$timeend) ";
		}
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total  FROM footprints ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+$lpp;
if($start+$lpp > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="footprints.dsub";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";



$sql=$Db1->query("SELECT footprints.* FROM footprints ".iif($conditions,"WHERE $conditions")." ORDER BY $orderby $type LIMIT $start, $lpp");
$total_footprints=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_footprints=$Db1->fetch_array($sql); $x++) {
		$footprintsslisted .= "
				<tr>
					<td>".date('g:i A - M d, Y', mktime(0,0,$this_footprints[dsub],1,1,1970))."</td>
					<td><a title=\"$this_footprints[uri]\">$this_footprints[title]</a></td>
					<td><a title=\"$this_footprints[uri]\">$this_footprints[url]</a></td>
					<td>$this_footprints[ip]</td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_footprints[username]."&s=$s&direct=footprints&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_footprints[username]</a></td>
				</tr>
";
	}
}
else {
	$footprintsslisted="
		<tr>
			<td class=\"tableHL2\" colspan=10 align=\"center\">No Search Results Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=footprints&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"uri\" ".iif($search_by == "uri", "SELECTED").">URL
			<option value=\"ip\" ".iif($search_by == "ip", "SELECTED").">IP
			<option value=\"dsub\" ".iif($search_by == "dsub", "SELECTED").">Date (dd/mm/yy)
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>

<table class=\"tableData\">
	<tr>
		<th><a href=\"admin.php?view=admin&ac=footprints&orderby=footprints.dsub&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Date</b> ".$order['footprints.dsub']."</a></th>
		<th><a href=\"admin.php?view=admin&ac=footprints&orderby=footprints.title&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Title</b> ".$order['footprints.title']."</a></th>
		<th><a href=\"admin.php?view=admin&ac=footprints&orderby=footprints.uri&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>URL</b> ".$order['footprints.uri']."</a></th>
		<th><a href=\"admin.php?view=admin&ac=footprints&orderby=footprints.uri&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>IP</b> ".$order['footprints.ip']."</a></th>
		<th><a href=\"admin.php?view=admin&ac=footprints&orderby=footprints.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order['footprints.username']."</a></th>
	</tr>
		$footprintsslisted
</table>

";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type footprint Entries<br />";
	if($ttotal > $lpp) {$bc.="[ ";}
	if($start >= $lpp) {
		$bstart=$start-$lpp;
		$bc.="<a href=\"admin.php?view=admin&ac=footprints&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start >= $lpp) && ($start+$lpp < $ttotal)) {$bc.=" :: ";}
	if($start+$lpp < $ttotal) {
		$start=$start+$lpp;
		$bc.=" <a href=\"admin.php?view=admin&ac=footprints&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > $lpp) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />";
//**E**//
?>
