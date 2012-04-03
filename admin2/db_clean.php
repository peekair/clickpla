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
$includes[title]="Database Cleaner";

function optimize() {
	global $Db1;
	$tables = $Db1->get_tables();
	for($x=0; $x<count($tables); $x++) {
	//	echo "<li>".$tables[$x]."<br /><menu>";
		if($x < (count($tables)-1)) {
			$xtra=", ";
		}
		else {
			$xtra="";
		}
		$optimize.=" `".$tables[$x]."`".$xtra;
		$fields=$Db1->get_fields($tables[$x]);
		for($y=0; $y<count($fields); $y++) {
	//		echo "<li>".$fields[$y]."";
		}
	//	echo "</menu>";
	}
	$Db1->query("REPAIR TABLE $optimize;");
	$Db1->query("OPTIMIZE TABLE $optimize;");
}

if($action == "duplicate_stats") {
	$sql=$Db1->query("SELECT * FROM stats");
	while($temp=$Db1->fetch_array($sql)) {
		echo "<!-- buffer -->";
		flush();
		if(!isset($tracker[$temp['date']])) {
			$tracker[$temp['date']]=array();
		}
		if($tracker[$temp['date']]['accounts']=="") {
			$tracker[$temp['date']]['accounts']=0;
			$tracker[$temp['date']]['title']=$temp['date'];
		}
		$tracker[$temp['date']]['accounts']+=1;
	}
	if(count($tracker) != 0) {
		foreach ($tracker as $temp1){
			echo "<!-- buffer -->";
			flush();
			if($temp1['accounts'] > 1) {
				$Db1->query("DELETE FROM stats WHERE date='$temp1[title]' LIMIT ".($temp1['accounts']-1)."");
			}
		}
	}
	$includes[content].="<b>All duplicated have been removed!</b><br /><br />";
}

if($action == "footprints") {
	$Db1->query("DELETE FROM footprints WHERE dsub < ".(time() - ($days*60*60*24))."");
	$includes[content].="<b>All footprints older than $days days have been removed!<br /><small>It is suggested that you now optimize the database (see below)</small></b><br /><br />";
}
if($action == "logs") {
	$Db1->query("DELETE FROM logs WHERE dsub < ".(time() - ($days*60*60*24))."");
	$includes[content].="<b>All logs older than $days days have been removed!<br /><small>It is suggested that you now optimize the database (see below)</small></b><br /><br />";
}
if($action == "errorlog") {
	$Db1->query("DELETE FROM error_log WHERE dsub < ".(time() - ($days*60*60*24))."");
	$includes[content].="<b>All Errorlogs older than $days days have been removed!<br /><small>It is suggested that you now optimize the database (see below)</small></b><br /><br />";
}
if($action == "optimize") {
	optimize();
	$includes[content].="<b>The database has been repaired and optimized!</b><br /><br />";
}

$includes[content].="

<form action=\"admin.php?view=admin&ac=db_clean&action=optimize&".$url_variables."\" method=\"post\">
<b>Optimize/Repair</b><br />
This will repair and optimize the database. Its a good idea to optimize your database at least weekly.
<input type=\"submit\" value=\"Repair/Optimize Database\">
</form>


<form action=\"admin.php?view=admin&ac=db_clean&action=footprints&".$url_variables."\" method=\"post\">
<b>Prune Footprints</b><br />
Delete all footprints older than <input type=\"text\" name=\"days\" value=\"30\" size=4> days 
<input type=\"submit\" value=\"Prune Footprints\">
</form>

<form action=\"admin.php?view=admin&ac=db_clean&action=duplicate_stats&".$url_variables."\" method=\"post\">
<b>Delete Duplicate Stats</b><br />
This will check for any duplicate stat rows and remove them. <input type=\"submit\" value=\"Remove Duplicates\">
</form>

<form action=\"admin.php?view=admin&ac=db_clean&action=logs&".$url_variables."\" method=\"post\">
<b>Prune Logs</b><br />
Delete all log entries older than <input type=\"text\" name=\"days\" value=\"30\" size=4> days 
<input type=\"submit\" value=\"Prune Logs\">
</form>

<form action=\"admin.php?view=admin&ac=db_clean&action=errorlog&".$url_variables."\" method=\"post\">
<b>Prune ErrorLogs</b><br />
Delete all error log entries older than <input type=\"text\" name=\"days\" value=\"30\" size=4> days 
<input type=\"submit\" value=\"Prune Error Logs\">
</form>

";

?>
