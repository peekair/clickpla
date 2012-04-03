<?
$includes[title]="Featured Ads Manager";
//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO fads SET
			title='".htmlentities($title)."',
			target='$target',
			username='$user',
			credits='$credits',
			views='$views',
			description='".addslashes($description)."',
			forbid_retract='$forbid_retract'
		");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=fads&".$url_variables."");
}

if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=fads&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}


if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" fads.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM fads ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="fads.credits";


if($orderby == "fads.id") {$ordernum=1;}
if($orderby == "fads.title") {$ordernum=2;}
if($orderby == "fads.username") {$ordernum=3;}
if($orderby == "fads.dsub") {$ordernum=4;}
if($orderby == "fads.credits") {$ordernum=5;}
if($orderby == "fads.views") {$ordernum=6;}
if($orderby == "fads.clicks") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT fads.* FROM fads WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_fad=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_fad[id]</td>
					<td><a href=\"$this_fad[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_fad&id=".$this_fad[id]."&s=$s&direct=fads&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."\">*".ucwords(strtolower(stripslashes($this_fad[title])))."</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_fad[username]."&s=$s&direct=fads&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."\">$this_fad[username]</a></td>
					<td>$this_fad[credits]</td>
					<td>$this_fad[views]</td>
					<td>$this_fad[clicks]</td>
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
<a href=\"admin.php?view=admin&ac=actfads&".$url_variables."\"><font size=\"4\">Activate ads</a></font>
<br>
<a href=\"admin.php?view=admin&ac=purgefads&".$url_variables."\"><font size=\"4\">Purge F.ads</a></font>
<br>
</div><br>
	
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=fads&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"description\" ".iif($search_by == "description", "SELECTED").">Ad
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>


<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=fads&orderby=fads.id&type=$newtype".iif($search_var,"$search_var")."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=fads&orderby=fads.title&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=fads&orderby=fads.username&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Username</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=fads&orderby=fads.credits&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Credits</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=fads&orderby=fads.views&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Views</b> ".$order[6]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=fads&orderby=fads.clicks&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Clicks</b> ".$order[7]."</a></th>
	</tr>
		$userslisted
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type fads<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=fads&start=$bstart&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=fads&start=$start&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


<div align=\"center\">
<form action=\"admin.php?view=admin&ac=fads&action=add&".$url_variables."\" method=\"post\">
<table cellspacing=\"1\" cellpadding=\"0\" border=0>
				<tr>
					<td colspan=2 align=\"center\"><b>New Featured Ad</b></td>
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
