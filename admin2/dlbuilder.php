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
$includes[title]="Referral Builder Program Manager";

//**S**//

if($action == "add") {
	$cats=":";
	for($x=0; $x<count($cat); $x++) {
		$cats.="".$cat[$x].":";
	}
	$sql=$Db1->query("INSERT INTO downline_builder SET
		title='$program',
		url='$purl',
		type='$ptype',
		defaultid='$pref',
		category='$cats',
		dsub='".time()."',
		description='".addslashes($description)."'
	");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=dlbuilder&".$url_variables."");
}


if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=dlbuilder&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($action == "update") {
	for($x=0; $x<count($reference); $x++) {
		$sql=$Db1->query("UPDATE downline_builder SET
			`order`='".$order[$reference[$x]]."'
		WHERE
			id='$reference[$x]'
		");
	}
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" downline_builder.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT * FROM dbl_cat ORDER BY title");
while($cat = $Db1->fetch_array($sql)) {
	$catlist.="<option value=\"$cat[id]\">$cat[title]";
}

$sql=$Db1->query("SELECT COUNT(id) AS total FROM downline_builder ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="downline_builder.order";


if($orderby == "downline_builder.id") {$ordernum=1;}
if($orderby == "downline_builder.title") {$ordernum=2;}
if($orderby == "downline_builder.url") {$ordernum=3;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT downline_builder.* FROM downline_builder ".iif($conditions,"WHERE  $conditions","")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_dbl=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_dbl[id]</td>
					<td><a href=\"admin.php?view=admin&ac=edit_dbl&id=".$this_dbl[id]."&s=$s&direct=dlbuilder&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">* ".ucwords(strtolower(stripslashes($this_dbl[title])))."</a></td>
					<td><a href=\"$this_dbl[url]$this_dbl[defaultid]\" target=\"_blank\">$this_dbl[url]$this_dbl[defaultid]</a></td>
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
<form action=\"admin.php?view=admin&ac=dlbuilder&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"url\" ".iif($search_by == "url", "SELECTED").">Url
			<option value=\"defaultid\" ".iif($search_by == "defaultid", "SELECTED").">Default ID
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>

<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=dlbuilder&orderby=downline_builder.id&type=$newtype".iif($search_var,"$search_var")."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=dlbuilder&orderby=downline_builder.title&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=dlbuilder&orderby=downline_builder.url&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>URL</b> ".$order[3]."</a></th>
	</tr>
		$userslisted
</table>

";

if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type programs<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=dlbuilder&start=$bstart&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=dlbuilder&start=$start&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=dlbuilder&action=add&".$url_variables."\" method=\"post\">

<b>Add New Referral Builder Program</b>

<table>
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" value=\"\" name=\"program\"></td>
		<td rowspan=4>&nbsp;&nbsp;
			<select name=\"cat[]\" size=5 multiple=1>
				$catlist
			</select>
		</td>
	</tr>
	<tr>
		<td>Type: </td>
		<td>
			<select name=\"ptype\">
				<option value=\"0\">Affiliate
				<option value=\"1\">Non-Affiliate
			</select>
		</td>
	</tr>
	<tr>
		<td>Base Url: </td>
		<td><input type=\"text\" value=\"\" name=\"purl\"></td>
	</tr>
	<tr>
		<td>Referral Id: </td>
		<td><input type=\"text\" value=\"\" name=\"pref\" size=\"10\"></td>
	</tr>
	<tr>
		<td colspan=3 align=\"center\"><textarea name=\"description\" cols=40 rows=5></textarea></td>
	</tr>
	<tr>
		<td colspan=3 align=\"center\"><input type=\"submit\" value=\"Add Program\"></td>
	</tr>
</table>
</form>

</div>

";
//**E**//
?>
