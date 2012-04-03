<?
//**VS**//$setting[ptc]//**VE**//

requireAdmin();
global $s, $url_variables;

//start, epp, sortType, sortOrder, searchStr, searchItem

$start=$_REQUEST['start'];
$epp=$_REQUEST['epp'];
$sortType=$_REQUEST['sortType'];
$sortOrder=$_REQUEST['sortOrder'];
$searchStr=$_REQUEST['searchStr'];
$searchItem=$_REQUEST['searchItem'];
$type=$_REQUEST['type'];


if($searchStr != "") {
	$searchStr2=explode(" ", $searchStr);
	for($x=0; $x<count($searchStr2); $x++) {
		$conditions.=" user.$searchItem LIKE '%$searchStr2[$x]%' ";
		if($x < (count($searchStr2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$searchStr&search_by=$searchItem";
}


$sql=$Db1->query("SELECT COUNT(userid) AS total FROM user ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+$epp;
if($start+$epp > $ttotal) {$end=$ttotal;}


if($sortOrder == "") 	$sortOrder="DESC";
if($sortOrder == "DESC") $newtype="ASC";
if($sortOrder == "ASC") 	$newtype="DESC";

if($sortType == "") 	$sortType="user.username";


$order[$sortType]="<img src=\"images/"."$sortOrder".".gif\" border=0>";

$sql=$Db1->query("SELECT * FROM member_groups ORDER BY title");
while(($temp=$Db1->fetch_array($sql))) {
	$grouplist[$temp[id]]=$temp[title];
}


$sql=$Db1->query("SELECT * FROM memberships");
while(($temp=$Db1->fetch_array($sql))) {
	$mm[$temp[id]]=$temp[title];
}


$sql=$Db1->query("SELECT user.* FROM user WHERE ".iif($conditions,"$conditions","1")." ORDER BY $sortType $sortOrder LIMIT $start, $epp");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; ($this_user=$Db1->fetch_array($sql)); $x++) {
		$userlisted .= "
			<tr>
				<td width=10><input type=\"checkbox\" value=\"1\" onclick=\"mm.tag($this_user[userid], this)\" ".iif($this_user[tagged] == 1,"checked=\"checked\"")."></td>
				<td>$this_user[userid]&nbsp;</td>
				<td><a href=\"#\" onclick=\"mm.edit_member($this_user[userid])\">$this_user[username]</a></td>
				
				<td >".iif(round($this_user[balance],2)>0,number_format(round($this_user[balance],2),2),"")."&nbsp;</td>
				<td >".iif(round($this_user[referral_earns],2)>0,number_format(round($this_user[referral_earns],2),2),"")."&nbsp;</td>
				<td>$this_user[referrals1]&nbsp;</td>
				<td align=\"center\">".iif($this_user[type]==0,"","Y")."&nbsp;</td>
				<td>$this_user[failed_logins]&nbsp;</td> 
				<td>".iif($this_user[ptphits] > 0, @number_format(round($this_user[ptphits]/($this_user[referrals1]>0?$this_user[referrals1]:1))), "0")."&nbsp;</td>
				<td>$this_user[last_ip]</td>
				<td>$this_user[refered]</td>
				<td>{$grouplist[$this_user[group]]}</td>
			</tr>
";
	}
}
else {
	$userlisted="
			<tr>
				<td colspan=12 align=center class=\"tableHL2\">No Results!</td>
			</tr>
	";
}

$includes[content].="


".iif($searchStr != "","
<div style=\"padding: 0 10 0 0px;\">
	$ttotal results found for: <b style=\"color: red\">
		".iif($searchItem=="tagged","Tagged","$searchStr")."
	</b>
</div>
")."

<div align=\"center\" style=\"padding: 3px;\">



<table class=\"tableData\" id=\"manager_table\">
	<tr>
		<th width=10>Tag</th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.userid', '$newtype')\"><b>ID</b> ".$order['user.userid']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.username', '$newtype')\"><b>Username</b> ".$order['user.username']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.balance', '$newtype')\"><b>Balance</b> ".$order['user.balance']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.referral_earns', '$newtype')\"><b>RE</b> ".$order['user.referral_earns']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.referrals', '$newtype')\"><b>Referrals</b> ".$order['user.referrals']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.type', '$newtype')\"><b>Prem</b> ".$order['user.type']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.failed_logins', '$newtype')\"><b>FL</b> ".$order['user.failed_logins']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.ptphits', '$newtype')\"><b>PTP</b> ".$order['user.ptphits']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.last_ip', '$newtype')\"><b>IP</b> ".$order['user.last_ip']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.refered', '$newtype')\"><b>Refered</b> ".$order['user.refered']."</a></th>
		<th><a href=\"#\" onclick=\"mm.sort_manager('user.group', '$newtype')\"><b>Group</b> ".$order['user.group']."</a></th>
	</tr>
	
		$userlisted
	
</table>

";
if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal Members<br />";
	if($ttotal > $epp) {$bc.="[ ";}
	if($start > ($epp-1)) {
		$bstart=$start-$epp;
		$bc.="<a href=\"#\" onclick=\"mm.change_manager_page($bstart)\">Back</a>";
	}
	if(($start > ($epp-1)) && ($start+$epp < $ttotal)) {$bc.=" :: ";}
	if($start+$epp < $ttotal) {
		$start=$start+$epp;
		$bc.=" <a href=\"#\" onclick=\"mm.change_manager_page($start)\">Next</a> ";
	}
	if($ttotal > $epp) {$bc.=" ]";}
}


$includes[content].=$bc."</div>

<div style=\"text-align: right; padding: 0 10 0 0px\">
<input type=\"button\" value=\"View Tagged\" onclick=\"mm.viewTagged()\">
<input type=\"button\" value=\"Refresh\" onclick=\"mm.refresh_manager()\">
<input type=\"button\" value=\"Reset View\" onclick=\"mm.reset_manager()\">
</div>




";

echo $includes[content];

?>
