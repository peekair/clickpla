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
$includes[title]="Manage PTR Ads";
//**VS**//$setting[ptra]//**VE**//
//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO ptrads SET 
			title='".addslashes($title)."', 
			ad='".addslashes($ad)."', 
			class='$cclass', 
			dsub='".time()."', 
			username='$user',
			credits='$credits',
			forbid_retract='$forbid_retract', 
			timed='$timed', 
			country='$country',
			bgcolor='$bgcolor',
			pamount='$pamount', 
			target='$target'
		");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=ptrads&".$url_variables."");
}


$thePermission=6;
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=ptrads&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" ptrads.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM ptrads ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="ptrads.title";


if($orderby == "ptrads.id") {$ordernum=1;}
if($orderby == "ptrads.title") {$ordernum=2;}
if($orderby == "ptrads.username") {$ordernum=3;}
if($orderby == "ptrads.pamount") {$ordernum=4;}
if($orderby == "ptrads.credits") {$ordernum=5;}
if($orderby == "ptrads.views") {$ordernum=6;}
if($orderby == "ptrads.timed") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT ptrads.* FROM ptrads WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_link=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_link[id]</td>
					<td><a href=\"$this_link[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_ptrad&id=".$this_link[id]."&s=$s&direct=ptrads&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">*".parse_link(ucwords(strtolower(stripslashes($this_link[title]))), 25)."</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_link[username]."&s=$s&direct=ptrads&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_link[username]</a></td>
					<td>$this_link[pamount]</td>
					<td>$this_link[timed]</td>
					<td>$this_link[credits]</td>
					<td>$this_link[views]</td>
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
<div align=\"left\"><font size=\"4\"><a href=\"admin.php?view=admin&ac=botad&".$url_variables."\">Bot Detector Setup</a><br></font>
<a href=\"admin.php?view=admin&ac=actptra&".$url_variables."\"><font size=\"4\">Activate ads</a></font><br><a href=\"admin.php?view=admin&ac=purgeptr&".$url_variables."\"><font size=\"4\">Purge PTR ads</a></font></div><br><div align=\"center\"><br>
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=ptrads&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"id\" ".iif($search_by == "id", "SELECTED").">Id
			<option value=\"title\" ".iif($search_by == "title", "SELECTED").">Title
			<option value=\"ad\" ".iif($search_by == "ad", "SELECTED").">Ad
			<option value=\"target\" ".iif($search_by == "target", "SELECTED").">Url
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>


<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.id&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.title&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.pamount&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Value</b> ".$order[4]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.timed&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Time</b> ".$order[7]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.credits&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Credits</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=ptrads&orderby=ptrads.views&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Views</b> ".$order[6]."</a></th>
	</tr>
	
		$userslisted
	
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type PTR Ads<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=ptrads&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=ptrads&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


<br /><br />


<div align=\"center\">
<form action=\"admin.php?view=admin&ac=ptrads&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\" name=\"form\">
<b>New PTR Ad</b>
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
		<td colspan=2><textarea name=\"ad\" cols=25 rows=4>$ad</textarea></td>
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
		<td>Time: </td>
		<td><input type=\"text\" name=\"timed\" value=\"25\"></td>
	</tr>
	<tr>
		<td>Target Country: </td>
		<td><select name=\"country\">".targetCountryList()."</select></td>
	</tr>
	<tr>
		<td>Class: </td>
		<td><select name=\"cclass\">
			<option value=\"A\">Class A
			<option value=\"B\">Class B
			<option value=\"C\">Class C
			<option value=\"D\">Class D
			<option value=\"P\">Points
		</select></td>
	</tr>
	<tr>
		<td>Link Value: </td>
		<td><input type=\"text\" name=\"pamount\" value=\"0\" size=5></td>
	</tr>
	<tr>
		<td>Highlight Color:</td>
		<td><input type=\"text\" value=\"$adinfo[bgcolor]\" name=\"bgcolor\"></td>
	</tr>
	<tr>
		<td colspan=2>Forbid Credit Retraction: <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Link\"></td>
	</tr>
</table>
</form>
</div>

";
//**E**//
?>
