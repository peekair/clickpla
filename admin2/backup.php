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
$includes[title]="Backup Database";
/*
if($action == "backup") {
	ini_set("max_execution_time","999");
	$time=time();
	echo "<!-- Dumping Database -->";
	flush();
	$command = `mysqldump --comments=false -Q --user=$DBUser --password=$DBPassword $DBDatabase > backups/$time.sql`;
	echo "<!-- zipping database -->";
	flush();
	$zipit = `tar -cf backups/$time.tar backups/$time.sql`;
	echo "<!-- Removing .sql File -->";
	$deletesql = `rm backups/$time.sql`;
	echo "<!-- Backup Complete -->";
	flush();
	$Db1->query("INSERT INTO backups SET 
			db_file='backups/$time.tar',
			db_size='".filesize("backups/$time.tar")."',
			dsub='".$time."'
	");
}

$sql=$Db1->query("SELECT * FROM backups ORDER BY dsub DESC");
while($backup = $Db1->fetch_array($sql)) {
	$list.="
		<tr class=\"tableHL2\">
			<td><a href=\"$backup[db_file]\">$backup[db_file]</a></td>
			<td>".number_format(ceil(($backup[db_size]/1024/1024)))." MB</td>
			<td>".date('m/d/y', mktime(0,0,$backup[dsub],1,1,1970))."</td>
		</tr>
	";
}
if($list == "") {
	$list="<tr class=\"tableHL2\"><td colspan=3 align=\"center\">There are no available backups!</tD></tR>";
}

$includes[content]="

<a href=\"admin.php?view=admin&ac=backup&action=backup&".$url_variables."\">Click Here To Make A New Backup</a>

<table class=\"tableBD1\" width=\"100%\" cellpadding=0 cellspacing=0>
	<tr>
		<td>
<table width=\"100%\" cellpadding=0 cellspacing=1>
	<tr class=\"tableHL1\">
		<td>File</td>
		<td>Size</td>
		<td>Date</td>
	</tr>
	$list
</table>
		</td>
	</tr>
</table>

";

*/

if($settingsdemo == 1) {
	$includes[content]="This feature is not available in the demo version!";
}
else {
$includes[content]="
<iframe width=\"100%\" height=500 src=\"backupDB.php\" frameborder=0></iframe>
";
}

?>
