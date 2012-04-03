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

if($tolorance == "") {
	$tolorance=5;
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


$sql=$Db1->query("SELECT * FROM user");
while($temp=$Db1->fetch_array($sql)) {
	if(!isset($tracker[$temp[last_ip]])) {
		$tracker[$temp[last_ip]]=array();
	}
	if($tracker[$temp[last_ip]]['accounts']=="") {
		$tracker[$temp[last_ip]]['accounts']=0;
		$tracker[$temp[last_ip]]['title']=$temp[last_ip];
	}
	$tracker[$temp[last_ip]]['accounts']+=1;
}

//					<td><a href=\"admin.php?view=admin&ac=runquery&action=run&query=UPDATE user SET balance='0' WHERE last_ip='". $temp1['title'] ."'&".$url_variables."\">Clear Earnings</a></td>

if(count($tracker) != 0) {
	foreach ($tracker as $temp1){
		if($temp1['accounts'] >= $tolorance) {
			$trackerlist.="
				<tr>
					<td><a href=\"admin.php?view=admin&ac=members&search=1&search_str=". $temp1['title'] ."&search_by=last_ip&step=2&".$url_variables."\">". $temp1['title'] ."</a></td>
					<td align=\"center\">". $temp1['accounts'] ."</td>
				</tr>";
		}
	}

	$includes[content]="
<form action=\"admin.php?view=admin&ac=findmultips&".$url_variables."\" method=\"post\">
Set Tolorance <input type=\"text\" name=\"tolorance\" value=\"$tolorance\" size=3> <input type=\"submit\" value=\"Update\">
</form>

<table width=\"350\">
	<tr>
		<td><b>Ip Address</td>
		<td align=\"center\"><b>Accounts</td>
	</tr>
	$trackerlist
</table>
";
}
else {
	$includes[content]="No tracked links have been accessed!";
}


//**E**//
?>
