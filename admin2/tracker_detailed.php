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

$sql=$Db1->query("
SELECT 
	ip, COUNT(*) as total, 
	SUM(visits) as tvisits, 
	SUM(register) as registered,
	MIN(dsub) as lowdsub,
	MAX(dsub) as highdsub
	
	FROM 
		tracker 
	WHERE 
		track_id like '$id'
	GROUP BY ip 
	
");

$totals['unique']=0;
$totals['hits']=0;
$totals['register']=0;
$totals['purchased']=0;
$totals['totalunique']=0;
$totals['totalhits']=0;
$totals['highdsub']=0;
$totals['lowdsub']=0;


while($temp=$Db1->fetch_array($sql)) {
//$temp['total']
	$totals['totalhits']+=$temp['tvisits'];
	$totals['totalunique']++;
	
	if($temp[highdsub] > $totals['highdsub'] || $totals['highdsub']==0) $totals['highdsub']=$temp[highdsub];
	if($temp[lowdsub] < $totals['lowdsub'] || $totals['lowdsub']==0) $totals['lowdsub']=$temp[lowdsub];
	
	if($temp[registered] > 0) {
		$sql2=$Db1->query("SELECT 
			user.username, 
			SUM(ledger.cost) as total 
		FROM user 
		LEFT JOIN ledger 
		ON ledger.username=user.username 
		WHERE user.last_ip='$temp[ip]'
		GROUP BY user.userid
		");
		$user=$Db1->fetch_array($sql2);
		
		
		$totals['hits']+=$temp['tvisits'];
		$totals['register']++;
		$totals['purchased']+=$user[total];
		
		$list.="
			<tr>
				<td>$temp[ip]</td>
				<td>".$temp['tvisits']."</td>
				<td>&nbsp; $user[username]</td>
				<td>".iif($user[total]>0,"\$$user[total]","&nbsp;")."</td>
			</tr>";
	}
	
}

if($action == "archive") {
	$Db1->query("INSERT INTO tracker_archive SET
		track_id='$id',
		start='".$totals['lowdsub']."',
		end='".$totals['highdsub']."',
		visits='".$totals['totalhits']."',
		uniques='".$totals['totalunique']."',
		register='".$totals['register']."',
		purchased='".$totals['purchased']."'
	");
	$Db1->query("DELETE FROM tracker WHERE track_id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?ac=tracker&".$url_variables."");
	exit;
//	$includes[content].="The tracker '$id' has been archived!<br /><a href=\"admin.php?ac=tracker_archive&".$url_variables."\">View Tracker Archive</a>";
}
else {
$includes[content].="
<b>Signup Log For Tracker: $id</b><br />
<table class=\"tableData\">
	<tr>
		<th>IP</th>
		<th>Visits</th>
		<th>Registered</th>
		<th>Purchased</th>
	</tr>
	$list
	<tr>
		<th>Totals:</th>
		<td>".$totals['hits']." hits</td>
		<td>".$totals['register']." signups</td>
		<td>\$".$totals['purchased']." purchased</td>
	</tr>
	<tr>
		<th>Overall Totals:</th>
		<td>".$totals['totalhits']." hits</td>
		<td>".$totals['totalunique']." uniqe hits</td>
	</tr>
</table>

<a href=\"admin.php?ac=tracker_detailed&id=$id&action=archive&".$url_variables."\" onclick=\"return confirm('Are you sure?')\">Snapshot Stats & Delete Logs</a>
";
}

/*
$sql2=$Db1->query("SELECT SUM(ledger.amount) as total FROM 
	user LEFT JOIN
	ledger ON
	ledger.username = user.username
	WHERE 
	user.last_ip='$temp[ip]'
	
");


$temp3=$Db1->fetch_array($sql2);
echo $temp3[total]." : ";

*/


?>