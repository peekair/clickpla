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
$includes[title]="Approve Users Manager";

//**S**//

if($act == "confirm_User") {
	$sql=$Db1->query("SELECT * FROM user WHERE confirm='0'");
		$userinfo=$Db1->fetch_array($sql);
		$Db1->query("UPDATE user SET confirm='1' WHERE userid='$userinfo[userid]'");
		
	$Db1->sql_close();
	header("Location: admin.php?ac=approvejoins&".$url_variables."");
	exit;
}











if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=approvejoins&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables."");
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


$sql=$Db1->query("SELECT COUNT(userid) AS total FROM user ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="user.confirm";


if($orderby == "user.username") {$ordernum=1;}
if($orderby == "user.last_ip") {$ordernum=2;}
if($orderby == "user.name") {$ordernum=3;}
if($orderby == "user.email") {$ordernum=4;}



	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT user.* FROM user WHERE confirm='0' and ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_banner=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>	
					<td><a href=\"admin.php?view=admin&ac=edit_user&id=".$this_banner[userid]."&s=$s&direct=members&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_banner[username] *</a></td>
					<td>$this_banner[last_ip]</td>
					<td>$this_banner[name]</td>
					<td>$this_banner[email]</td>
					<td>
					<form action=\"admin.php?view=admin&ac=approvejoins&search=1&".$url_variables."\" method=\"post\">
<input type=\"submit\" name=\"act\" value=\"confirm_User\">
                    </form>
					</td>
					
						
					
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
<form action=\"admin.php?view=admin&ac=approvejoins&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"userid\" ".iif($search_by == "userid", "SELECTED").">User Id
			<option value=\"last_ip\" ".iif($search_by == "last_ip", "SELECTED").">IP Address
			<option value=\"email\" ".iif($search_by == "email", "SELECTED").">Email
			<option value=\"banner\" ".iif($search_by == "name", "SELECTED").">Name
		</select>
		<br /><input type=\"submit\" value=\"Search\"> <a href=\"admin.php?view=admin&ac=approvaljoins&".$url_variables."\">Reset</a></td>
	
	</tr>
</table>

</form>


<table class=\"tableData\">
	<tr>
	
		<th><b><a href=\"admin.php?view=admin&ac=approvejoins&orderby=user.username&type=$newtype".iif($search_var,"$search_var")."\">Username ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=approvejoins&orderby=user.last_ip&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>IP</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=approvejoins&orderby=user.name&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Name</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=approvejoins&orderby=user.email&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>E-mail</b> ".$order[5]."</a></th>
	   <th><b>Confirm User</b></th>
	</tr>
		$userslisted
</table>

";

if($ttotal != 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type users<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"admin.php?view=admin&ac=approvejoins&start=$bstart&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"admin.php?view=admin&ac=approvejoins&start=$start&orderby=$orderby&type=$type".iif($search_var,"$search_var")."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}


$includes[content].=$bc."</div>


";
//**E**//
?>
