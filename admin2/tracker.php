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
$includes[title]="Tracker";
//**S**//

/*
	$tracker[track_id]
	$tracker[track_id] ['visits']
	$tracker[track_id] ['unique']
	$tracker[track_id] ['ips']   [ip_address]
*/

if($action == "delete") {
	$sql=$Db1->query("DELETE FROM tracker WHERE track_id='$title'");
}

function find_ip($ips, $ip) {
	$return=0;
	foreach ($ips as $thisip) {
    	if($thisip == $ip) {
			$return=1;
		}
	}
	return $return;
}


$sql=$Db1->query("SELECT * FROM tracker");
while($temp=$Db1->fetch_array($sql)) {
	if(!isset($tracker[$temp[track_id]])) {
		$tracker[$temp[track_id]]=array();
	}
	if($tracker[$temp[track_id]]['visits']==0) {
		$tracker[$temp[track_id]]['visits']=0;
		$tracker[$temp[track_id]]['unique']=0;
		$tracker[$temp[track_id]]['register']=0;
		$tracker[$temp[track_id]]['title']=$temp[track_id];
		$tracker[$temp[track_id]]['ips']=array();
	}
	if(find_ip($tracker[$temp[track_id]]['ips'], $temp[ip]) == 0) {
		$tracker[$temp[track_id]]['ips']['$temp[ip]']="$temp[ip]";
		$tracker[$temp[track_id]]['unique']+=1;
	}
	if($temp[register] != 0) {
		
		$tracker[$temp[track_id]]['register'] += $temp[register];
	}
	$tracker[$temp[track_id]]['visits']+=$temp['visits'];
}


if(count($tracker) != 0) {
	foreach ($tracker as $temp1){

		$trackerlist.="
	<tr>
		<td><a href=\"admin.php?ac=tracker_detailed&id=". $temp1['title'] ."&".$url_variables."\">". $temp1['title'] ."</a></td>
		<td align=\"center\">". $temp1['visits'] ."</td>
		<td align=\"center\">". $temp1['unique'] ."</td>
		<td align=\"center\">". $temp1['register'] ."</td>
		<td align=\"center\">
			<a href=\"admin.php?ac=tracker_detailed&id=". $temp1['title'] ."&action=archive&".$url_variables."\" onclick=\"return confirm('Are you sure?')\">Archive</a> | 
			<a href=\"admin.php?view=admin&ac=tracker&action=delete&title=". $temp1['title'] ."&".$url_variables."\">Delete</a></td>
	</tr>";
	}

	$includes[content]="
<table class=\"tableData\">
	<tr>
		<th><b>Tracker Title</th>
		<th align=\"center\"><b>Raw Hits</th>
		<th align=\"center\"><b>Unique Hits</th>
		<th><b>Registers</th>
		<th align=\"center\"><b>Delete</th>
	</tr>
	$trackerlist
</table>
";
}
else {
	$includes[content]="No tracked links have been accessed!";
}

$includes[content].="<br /><br />
<small>
<b>How To Use Link Tracker:</b><br />
Send Hits To http://www.$settings[domain_name]/index.php?track=XXX<br /><br />

Replace XXX with a simple title (No special characters or quotes)
</small>
";
//**E**//
?>
