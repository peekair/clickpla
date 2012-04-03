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
$includes[title]="Paid To Signup: Offer Completion History";
//**VS**//$setting[ptsu]//**VE**//
//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$sql = $Db1->query("SELECT ptsu_log.*, ptsuads.title FROM ptsu_log, ptsuads WHERE ptsu_log.username='$username' and ptsuads.id=ptsu_log.ptsu_id");
$logs=$Db1->num_rows();
while($temp = $Db1->fetch_array($sql)) {
	$list.="
	<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
		<td>$temp[title]</td>
		<td>".iif($temp['class']=="P","$temp[pamount] Points","$cursym $temp[pamount]")."</td>
		<td>".date('m/d/y', mktime(0,0,$temp[dsub],1,1,1970))."</td>
		<td>".
		iif($temp[status]==0,"Pending Admin Approval").
		iif($temp[status]==1,"Approved").
		iif($temp[status]==2,"Pending Advertiser Approval").
		iif($temp[status]==3,"Denied by Admin").
		iif($temp[status]==4,"Denied by Advertiser")
		."</td>
	</tr>
	";
}



if($logs > 0) {
	$includes[content]="
<div align=\"right\" style=\"font-size: 13px;\">
<a href=\"index.php?view=account&ac=ptsu&".$url_variables."\">Return to Paid To Signup Area</a>
</div>

<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100%\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td><b>Offer Title</b></td>
					<td><b>Worth</b></td>
					<td><b>Date</b></td>
					<td><b>Status</b></td>
				</tr>
				$list
			</table>
		</td>
	</tr>
</table>
	";
}
else {
	$includes[content]="You have not completed any offers!";
}

//**E**//
?>