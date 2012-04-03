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
$sql=$Db1->query("SELECT * FROM tracker_archive ORDER BY track_id");
while($temp=$Db1->fetch_array($sql)) {
	$list.="
	<tr>
		<td style=\"text-align: left\">".$temp['track_id']."</td>
		<td>".$temp['visits']."</td>
		<td>".$temp['uniques']."</td>
		<td>".$temp['register']."</td>
		<td>".$temp['purchased']."</td>
		<td>".date('m/d/y', mktime(0,0,$temp['start'],1,1,1970))."</td>
		<td>".date('m/d/y', mktime(0,0,$temp['end'],1,1,1970))."</td>
		<td>".floor(($temp['end']-$temp['start'])/60/60/24)." days</td>
	</tr>
	";
}

$includes[content]="
<table class=\"tableStyle2\">
	<tr class=\"tableHead\">
		<td><b>Id</b></td>
		<td><b>Hits</b></td>
		<td><b>Unique</b></td>
		<td><b>Signups</b></td>
		<td><b>Purchased</b></td>
		<td colspan=2><b>Date Range</b></td>
		<td><b>Days</b></td>
	</tr>
	$list
</table>
";

?>