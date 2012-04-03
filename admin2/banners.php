<?
$includes[title]="Banner Manager";

//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO banners SET 
		title='".htmlentities($title)."',
		target='$target',
		banner='$banner',
		username='$user',
		dsub='".time()."',
		credits='$credits',
		forbid_retract='$forbid_retract'");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=banners&".$url_variables."");
}

if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=banners&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" banners.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM banners ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="banners.credits";


if($orderby == "banners.id") {$ordernum=1;}
if($orderby == "banners.title") {$ordernum=2;}
if($orderby == "banners.username") {$ordernum=3;}
if($orderby == "banners.dsub") {$ordernum=4;}
if($orderby == "banners.credits") {$ordernum=5;}
if($orderby == "banners.views") {$ordernum=6;}
if($orderby == "banners.clicks") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT banners.* FROM banners WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_banner=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
				<td colspan=2 align=\"center\"><a href=\"$this_banner[target]\" target=\"_blank\"><img src=\"$this_banner[banner]\" border=0 width=\"".iif($this_banner[size]==180,"180","468")."\" height=\"".iif($this_banner[size]==180,"100","60")."\"></a></td>
					<td>$this_banner[id]</td>
					<td><a href=\"$this_banner[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_banner&id=".$this_banner[id]."&s=$s&direct=banners&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">*".ucwords(strtolower(stripslashes($this_banner[title])))."</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_banner[username]."&s=$s&direct=banners&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."\">$this_banner[username]</a></td>
					<td>$this_banner[credits]</td>
					<td>$this_banner[views]</td>
					<td>$this_banner[clicks]</td>
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

<a href=\"admin.php?view=admin&ac=actbanners&".$url_variables."\"><font size=\"4\">Activate ads</a></font>
<br>

<a href=\"admin.php?view=admin&ac=purgebanners&".$url_variables."\"><font size=\"4\">Purge Banners and F.Banners</a></font></div><br>
<br>
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=banners&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Target Url
			<option value=\"banner\" ".iif($search_by == "banner", "SELECTED").">Banner Url
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>


<table class=\"tableData\">
	<tr>
		<th><b>Image Banner </b><th>
		<th><b><a href=\"admin.php?view=admin&ac=banners&orderby=banners.id&type=$newtype".iif($search_var,"$search_var")."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=banners&orderby=banners.title&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=banners&orderby=banners.username&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Username</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=banners&orderby=banners.credits&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Credits</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=banners&orderby=banners.views&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Views</b> ".$order[6]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=banners&orderby=banners.clicks&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Clicks</b> ".$order[7]."</a></th>
	</tr>
		$userslisted
</table>

";

if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type banners<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=banners&start=$bstart&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=banners&start=$start&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=banners&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<b>New Banner Ad</b>
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
		<td>Banner Url: </td>
		<td><input type=\"text\" name=\"banner\" value=\"$banner\"></td>
	</tr>
	<tr>
		<td>Username: </td>
		<td><input type=\"text\" name=\"user\" value=\"$user\"></td>
	</tr>
	<tr>
		<td>Credits: </td>
		<td><input type=\"text\" name=\"credits\" value=\"$credits\"></td>
	</tr>
	<tr>
		<td colspan=2>Forbid Credit Retraction: <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Banner\"></td>
	</tr>
</table>
</form>
</div>

";
//**E**//
?>
