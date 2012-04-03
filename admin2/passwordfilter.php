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
$includes[title]="Account Password Filter";
//**S**//

if($tolorance == "") {
	$tolorance=2;
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

if($action == "go") {
	for($y=0; $y<count($selected); $y++) {
		$x=$selected[$y];
//		if($selected[$x] == 1) {
			echo "Running Through Accounts...$selectedid[$x]<br />";
			flush();
			if($suspend == 1) {
				echo "Suspending Accounts...<br />";
				flush();
				$Db1->query("UPDATE user SET suspended='1' WHERE password='$selectedid[$x]'");
			}
			if($payments != "") {
				$sql=$Db1->query("SELECT * FROM user WHERE password='$selectedid[$x]'");
				while($temp=$Db1->fetch_array($sql)) {
					echo "Openning Account... $temp[username]<br />";
					flush();
					$sql=$Db1->query("SELECT * FROM requests WHERE id='$temp[username]'");
					echo "Looking For Requests... $temp[username]<br />";
					flush();
					while($request=$Db1->fetch_array($sql)) {
						if($payments == "cancel") {
							echo "Cancelling Request...<br />";
							flush();
							$Db1->query("DELETE FROM requests WHERE id='$request[id]'");
							$Db1->query("UPDATE user SET balance=balance+".($request[amount]+$request[fee])." WHERE username='$request[username]'");
							$sql=$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Cancelled By Admin: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
						}
						if($payments == "delete") {
							echo "Deleting Request...<br />";
							flush();
							$Db1->query("DELETE FROM requests WHERE id='$request[id]'");	
							$sql=$Db1->query("INSERT INTO logs SET username='".$request[username]."', log='Request Deleted By Admin: Gross: ".$request[amount].", Fee: ".$request[fee].", Account: ".$request[account]."', dsub='".time()."'");
						}
					}
				}
			}
//		}
	}

	echo "<b>Done</b><script>alert('All Actions Done! Press The Back Button In Your Browser')</script>";
	flush();
	$Db1->sql_close();
	exit;
}


$sql=$Db1->query("SELECT * FROM user");
while($temp=$Db1->fetch_array($sql)) {
	if(!isset($tracker[$temp[password]])) {
		$tracker[$temp[password]]=array();
	}
	if(!isset($tracker[$temp[password]]['ips'])) {
		$tracker[$temp[password]]['ips']=array();
	}
	if($tracker[$temp[password]]['accounts']=="") {
		$tracker[$temp[password]]['acounts']=0;
		$tracker[$temp[password]]['title']=$temp[password];
	}
	$tracker[$temp[password]]['ips'][$temp[last_ip]]=1;
	$tracker[$temp[password]]['accounts']+=1;
}

//					<td><a href=\"admin.php?view=admin&ac=runquery&action=run&query=UPDATE user SET balance='0' WHERE last_ip='". $temp1['title'] ."'&".$url_variables."\">Clear Earnings</a></td>


if(count($tracker) != 0) {
	$xx=0;
	foreach ($tracker as $temp1){
		if(($temp1['accounts'] >= $tolorance) && (($blockl==1) || (count($temp1['ips']) != $temp1['accounts']))) {
			$xx++;
			$trackerlist.="
				<tr".iif(count($temp1['ips'])==1," bgcolor=\"lightyellow\"").">
					<td>
						<input type=\"hidden\" name=\"selectedid[$xx]\" value=\"".$temp1['title']."\">
						<input type=\"checkbox\" name=\"selected[]\" value=\"$xx\"".iif(count($temp1['ips'])==1,"checked=\"checked\"").">
					</td>
					<td><a href=\"admin.php?view=admin&ac=members&search=1&search_str=". $temp1['title'] ."&search_by=password&step=2&".$url_variables."\">". $temp1['title'] ."</a></td>
					<td align=\"center\">". $temp1['accounts'] ."</td>
					<td align=\"center\">". count($temp1['ips']) ."</td>
					<td><a href=\"admin.php?view=admin&ac=pendingrequests&search_by=password&search=1&search_str=".$temp1['title']."&".$url_variables."\">Pending Requests</a></td>
					<td><a href=\"admin.php?view=admin&ac=runquery&action=run&query=UPDATE user SET suspended='1' WHERE password='".$temp1['title']."'&".$url_variables."\">Suspend Accounts</a></td>
				</tr>";
		}
	}

	$includes[content]="
<form action=\"admin.php?view=admin&ac=passwordfilter&".$url_variables."\" method=\"post\">
Show 100% Unique <input type=\"checkbox\" name=\"blockl\" value=\"1\"".iif($blockl==1,"checked=\"checked\"")."><br />
Set Account Tolorance <input type=\"text\" name=\"tolorance\" value=\"$tolorance\" size=3> <input type=\"submit\" value=\"Update\">
</form>

<form action=\"admin.php?view=admin&ac=passwordfilter&action=go&tolorance=$tolorance&".$url_variables."\" method=\"post\">
<table width=\"450\">
	<tr>
		<td></td>
		<td><b>Password</td>
		<td align=\"center\"><b>Accounts</td>
		<td align=\"center\"><b>Unique Ips</td>
	</tr>
	$trackerlist
</table>
<br />

Queued Payments Action: 
<select name=\"payments\">
	<option value=\"\">Nothing
	<option value=\"cancel\">Cancel Queued Payments
	<option value=\"delete\">Delete Queued Payments
</select><br />

Suspend Accounts <input type=\"checkbox\" name=\"suspend\" value=\"1\">

<br />

<input type=\"submit\" value=\"Do Actions\">

</form>
";
}
else {
	$includes[content]="No tracked links have been accessed!";
}


//**E**//
?>
