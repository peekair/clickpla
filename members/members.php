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
$includes[title]="Member Manager";


if($act == "Delete") {
	foreach($multiSelect as $k => $v) {
		deleteUser($k);
//		echo " : $k ";
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=members&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."");
	exit;
}



//**S**//
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=members&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" user.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(userid) AS total  FROM user ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="ASC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="user.username";
if($orderby == "user.userid") {$ordernum=11;}
if($orderby == "user.ptpearns") {$ordernum=1;}
if($orderby == "user.username") {$ordernum=2;}
if($orderby == "user.balance") {$ordernum=8;}
if($orderby == "user.referrals") {$ordernum=9;}
if($orderby == "user.referrals1") {$ordernum=10;}
if($orderby == "user.referral_earns") {$ordernum=12;}
if($orderby == "user.refered") {$ordernum=13;}
if($orderby == "user.points") {$ordernum=14;}
if($orderby == "user.membership") {$ordernum=15;}
if($orderby == "user.last_ip") {$ordernum=16;}
if($orderby == "user.floodguard") {$ordernum=17;}
if($orderby == "user.floodguard_today") {$ordernum=18;}
if($orderby == "user.clicks") {$ordernum=19;}
if($orderby == "user.failed_logins") {$ordernum=20;}
if($orderby == "user.paid") {$ordernum=25;}
if($orderby == "user.country") {$ordernum=26;}
if($orderby == "(user.ptphits/user.referrals1)") {$ordernum=21;}
if($orderby == "user.suspended ") {$ordernum=27;}
if($orderby == "user.join_ip") {$ordernum=28;}
if($orderby == "user.permission") {$ordernum=29;}



	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT * FROM member_groups ORDER BY title");
while($temp=$Db1->fetch_array($sql)) {
	$grouplist[$temp[id]]=$temp[title];
}


$sql=$Db1->query("SELECT * FROM memberships");
while($temp=$Db1->fetch_array($sql)) {
	$mm[$temp[id]]=$temp[title];
}
	
$sql=$Db1->query("SELECT user.* FROM user ".iif($conditions,"WHERE $conditions")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_user=$Db1->fetch_array($sql); $x++) { //((100000/(($this_user[referrals1]*100000) / $this_user[ptphits]))/100)
		$userslisted .= "
				<tr>
					<td style=\"width: 10px\">
						<input type=\"checkbox\" name=\"multiSelect[".$this_user[userid]."]\" value=\"1\" checked=\"checked\">
					</td>
					<td>$this_user[userid]&nbsp;</td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&id=".$this_user[userid]."&s=$s&direct=members&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_user[username] *</a>&nbsp;</td><td NOWRAP=\"NOWRAP\">$this_user[country]&nbsp;</td> 
                                        <td style=\"padding: 0 10 0 10px;\"><a href=\"admin.php?view=admin&ac=members&search=1&search_by=permission&search_str=$this_user[permission]&".$url_variables."\">$this_user[permission]</a>&nbsp;</td>
					<td  align=\"right\">".iif(round($this_user[balance],2)>0,number_format(round($this_user[balance],2),2),"")."&nbsp;</td>
					<td  align=\"right\">".iif(round($this_user[referral_earns],2)>0,number_format(round($this_user[referral_earns],2),2),"")."&nbsp;</td>
					<td>$this_user[referrals1]&nbsp;</td>
					<td align=\"center\">".iif($this_user[type]==0,"","Y")."&nbsp;</td>
					<td>$this_user[failed_logins]&nbsp;</td> 
					<td>".iif($this_user[ptphits] > 0, @number_format(round($this_user[ptphits]/($this_user[referrals1]>0?$this_user[referrals1]:1))), "0")."&nbsp;</td>
					<td style=\"padding: 0 10 0 10px;\"><a href=\"admin.php?view=admin&ac=members&search=1&search_by=last_ip&search_str=$this_user[last_ip]&".$url_variables."\">$this_user[last_ip]</a>&nbsp;</td>
                                        <td style=\"padding: 0 10 0 10px;\"><a href=\"admin.php?view=admin&ac=members&search=1&search_by=join_ip&search_str=$this_user[join_ip]&".$url_variables."\">$this_user[join_ip]</a>&nbsp;</td>
					<td align=\"right\"><a href=\"admin.php?view=admin&ac=edit_user&uname=$this_user[refered]&".$url_variables."\">$this_user[refered]</a>&nbsp;</td>
					<td align=\"center\">".iif($this_user[suspended ]==0,"","Y")."&nbsp;</td>
					<td align=\"right\"><a href=\"admin.php?ac=members&search=1&search_str=".$this_user[group]."&search_by=group&step=2&".$url_variables."\">".$grouplist[$this_user[group]]."</a>&nbsp;</td>
				</tr>
";
	}
}
else {
	$userslisted="
		<tr>
			<td class=\"tableHL2\" colspan=11 style=\"text-align: center\">No Search Results Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=members&search=1&".$url_variables."\" method=\"post\">
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
			<option value=\"country\" ".iif($search_by == "country", "SELECTED").">Country
			<option value=\"permission\" ".iif($search_by == "permission", "SELECTED").">Permission (0 or 6 or 7)
			<option value=\"suspended\" ".iif($search_by == "suspended", "SELECTED").">Suspended (0 or 1)
			<option value=\"notes\" ".iif($search_by == "notes", "SELECTED").">Notes
			<option value=\"group\" ".iif($search_by == "group", "SELECTED").">Group ID
		</select>
		<br /><input type=\"submit\" value=\"Search\"> <a href=\"admin.php?view=admin&ac=members&".$url_variables."\">Reset</a></td>
	</tr>
</table>
</form>

<form action=\"admin.php?view=admin&ac=members&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\" method=\"post\">
			<table class=\"tableData\">
				<tr>
					<th style=\"width: 10px\">&nbsp;</th>
					<th><b><a href=\"admin.php?view=admin&ac=members&orderby=user.userid&type=$newtype".iif($search_var,"$search_var")."&".$url_variables."\">Id ".$order[11]."</a></b></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order[2]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.country&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Country</b> ".$order[26]."</a></th>
                                        <th><a href=\"admin.php?view=admin&ac=members&orderby=user.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Permission</b> ".$order[29]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.balance&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Balance</b> ".$order[8]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.referral_earns&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>RE</b> ".show_help("Referral earnings")." ".$order[12]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.referrals1&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Lvl 1</b> ".show_help("Level 1 referrals")." ".$order[10]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.membership&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Pro</b> ".show_help("Displays if the member has an upgraded account or not.")."</b> ".$order[15]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.failed_logins&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>FL</b> ".show_help("Failed Logins - This is how many times a user has failed to login due to entering wrong information.")."</b> ".$order[20]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=(user.ptphits/user.referrals1)&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>SC ".show_help("PTP Signup Score - This number helps find ptp cheaters. The number represents how many ptp hits were paid per 1 signups. The higher this number is, the higher the chance that they are using an emulator. ")."</b> ".$order[21]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.last_ip&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Ip Address</b> ".$order[16]."</a></th>
                                        <th><a href=\"admin.php?view=admin&ac=members&orderby=user.join_ip&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Join IP</b> ".$order[28]."</a></th>
					<th align=\"center\"><a href=\"admin.php?view=admin&ac=members&orderby=user.refered&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Referrer</b> ".$order[13]."</a></th>
				<th><a href=\"admin.php?view=admin&ac=members&orderby=user.suspended&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Suspended</b> ".show_help("Displays if the member has a suspended account or not.")."</b> ".$order[27]."</a></th>
					<th><a href=\"admin.php?view=admin&ac=members&orderby=user.group&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Group</b> ".$order[14]."</a></th>
				</tr>
				
					$userslisted
				
			</table>


<div style=\"text-align: left;\"> <b>With Selected: </b> <input type=\"submit\" name=\"act\" value=\"Delete\" onclick=\"return confirm('Are you sure?')\"></div>

</form>
";

//((100000/((user.referrals1*100000) / user.ptphits))/100)

if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Members<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=members&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=members&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />";
//**E**//
?>