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
$includes[title]="Clean Daily Stats";

if($action == "delete") {
	$sql=$Db1->query("SELECT * FROM stats");
	while($temp=$Db1->fetch_array($sql)) {
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
			if($temp1['accounts'] > 1) {
				$Db1->query("DELETE FROM stats WHERE date='$temp1[title]' LIMIT ".($temp1['accounts']-1)."");
			}
		}
	}
	$includes[content]="All duplicate entries have been removed.";
}
else {
$includes[content]="
This tool will sort through and delete any duplicate entries in the daily stats database.<br /><br />

<input type=\"button\" value=\"Delete Duplicates\" onclick=\"location.href='admin.php?view=admin&ac=delete_duplicate_stats&action=delete&".$url_variables."'\">
";
}


?>
