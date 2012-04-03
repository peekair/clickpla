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
$includes[title]="Deleted Member Manager";

//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=deleted_members&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" user_deleted.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(userid) AS total FROM user_deleted ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="ASC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="user_deleted.username";
if($orderby == "user_deleted.userid") {$ordernum=11;}
if($orderby == "user_deleted.ptpearns") {$ordernum=1;}
if($orderby == "user_deleted.username") {$ordernum=2;}
if($orderby == "user_deleted.balance") {$ordernum=8;}
if($orderby == "user_deleted.clicks") {$ordernum=9;}
if($orderby == "user_deleted.referral_earns") {$ordernum=12;}
if($orderby == "user_deleted.points") {$ordernum=14;}
if($orderby == "user_deleted.paid") {$ordernum=25;}
if($orderby == "user_deleted.refered") {$ordernum=13;}
if($orderby == "user_deleted.membership") {$ordernum=15;}
if($orderby == "user_deleted.last_ip") {$ordernum=16;}

	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";


$sql=$Db1->query("SELECT * FROM memberships");
while($temp=$Db1->fetch_array($sql)) {
	$mm[$temp[id]]=$temp[title];
}
	
$sql=$Db1->query("SELECT user_deleted.* FROM user_deleted ".iif($conditions,"WHERE $conditions")." ORDER BY $orderby $type LIMIT $start, 25");
$total_deleted_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_user=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$this_user[userid]</td>
					<td><a href=\"admin.php?view=admin&ac=edit_deleted_user&id=".$this_user[userid]."&s=$s&direct=deleted_members&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_user[username] *</a></td>
					<td>$cursym $this_user[balance]</td>
					<td>$this_user[clicks]</td>
					<td>$this_user[points]</td>
					<td>".iif($this_user[type]==0,"Basic",$mm[$this_user[membership]])."</td>
					<td>$this_user[refered]</td>
					<td><a href=\"admin.php?view=admin&ac=deleted_members&search=1&search_by=last_ip&search_str=$this_user[last_ip]&".$url_variables."\">$this_user[last_ip]</a></td>
				</tr>
";
	}
}
else {
	$userslisted="
		<tr>
			<td class=\"tableHL2\" colspan=8 align=\"center\">No Search Results Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=deleted_members&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"userid\" ".iif($search_by == "userid", "SELECTED").">Id
			<option value=\"name\" ".iif($search_by == "name", "SELECTED").">Name
			<option value=\"email\" ".iif($search_by == "email", "SELECTED").">Email
			<option value=\"refered\" ".iif($search_by == "refered", "SELECTED").">Referrer
			<option value=\"last_ip\" ".iif($search_by == "last_ip", "SELECTED").">Ip Address
			<option value=\"password\" ".iif($search_by == "password", "SELECTED").">Password
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>

<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.userid&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Id ".$order[11]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.balance&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Balance</b> ".$order[8]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.clicks&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Clicks</b> ".$order[9]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.points&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Points</b> ".$order[14]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.membership&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Type</b> ".$order[15]."</a></th>
		<th align=\"center\"><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.refered&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Referrer</b> ".$order[13]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=deleted_members&orderby=user_deleted.last_ip&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Ip Address</b> ".$order[16]."</a></th>
	</tr>
		$userslisted	
</table>

";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Deleted Members<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=deleted_members&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=deleted_members&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />";
//**E**//
?>
