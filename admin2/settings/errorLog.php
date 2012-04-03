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
$includes[title]="Site Log";

$lpp=15;

//**S**//
if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=errorLog&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		if($search_by != "dsub") $conditions.=" error_log.$search_by LIKE '%$search_str2[$x]%' ";
		else {
			$temp1=explode("/",$search_str);
			$timestart=mktime(0,0,0,$temp1[1],$temp1[0],$temp1[2]);
			$timeend=mktime(0,0,0,$temp1[1],($temp1[0]+1),$temp1[2]);
			$conditions.=" (error_log.dsub>$timestart and error_log.dsub<$timeend) ";
		}
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total  FROM error_log ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+$lpp;
if($start+$lpp > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="error_log.dsub";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";



$sql=$Db1->query("SELECT error_log.* FROM error_log ".iif($conditions,"WHERE $conditions")." ORDER BY $orderby $type LIMIT $start, $lpp");
$total_logs=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_logs=$Db1->fetch_array($sql); $x++) {
		$logsslisted .= "
				<tr>
					<td>".date('M d, Y', mktime(0,0,$this_logs[dsub],1,1,1970))."</td>
					<td>$this_logs[error]</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=".$this_logs[username]."&s=$s&direct=logs&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">$this_logs[username]</a></td>
				</tr>
";
	}
}
else {
	$logsslisted="
		<tr>
			<td class=\"tableHL2\" colspan=10 align=\"center\">No Search Results Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=errorLog&search=1&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" ".iif($search_by == "username", "SELECTED").">Username
			<option value=\"error\" ".iif($search_by == "error", "SELECTED").">Log
			<option value=\"dsub\" ".iif($search_by == "dsub", "SELECTED").">Date (dd/mm/yy)
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>

<table class=\"tableData\">
	<tr>
		<th><a href=\"admin.php?view=admin&ac=errorLog&orderby=error_log.dsub&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Date</b> ".$order['error_log.dsub']."</a></th>
		<th><a href=\"admin.php?view=admin&ac=errorLog&orderby=error_log.error&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Log</b> ".$order['error_log.error']."</a></th>
		<th><a href=\"admin.php?view=admin&ac=errorLog&orderby=error_log.username&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Username</b> ".$order['error_log.username']."</a></th>
	</tr>
		$logsslisted
</table>

";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Log Entries<br />";
	if($ttotal > $lpp) {$bc.="[ ";}
	if($start >= $lpp) {
		$bstart=$start-$lpp;
		$bc.="<a href=\"admin.php?view=admin&ac=errorLog&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start >= $lpp) && ($start+$lpp < $ttotal)) {$bc.=" :: ";}
	if($start+$lpp < $ttotal) {
		$start=$start+$lpp;
		$bc.=" <a href=\"admin.php?view=admin&ac=errorLog&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > $lpp) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />";
//**E**//
?>
