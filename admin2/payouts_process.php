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
$includes[title]="Process Automated Payouts";

if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

if($settings[auto_pay_on]) {
	$sql=$Db1->query("SELECT * FROM withdraw_options ORDER BY title");
	while($wo = $Db1->fetch_array($sql)) {
		$sql2=$Db1->query("SELECT SUM(balance) as total FROM user WHERE auto_pay='1' and auto_method='$wo[id]' and auto_account!='' and balance >=$wo[minimum]");
		$temp=$Db1->fetch_array($sql2);
		$payoutlist.="
		<tr>
			<td><a href=\"admin.php?view=admin&ac=payouts_process2&id=$wo[id]&".$url_variables."\">$wo[title]</a></td>
			<td>$cursym ".round($temp[total],2)."</td>
		</tr>
		";
	}
	$includes[content]="
This will process any accounts that meet the requirements for auto-payment.

<table width=200>
	<tr>
		<td><b>Method</b></td>
		<td><b>Available</b></td>
	</tr>
	$payoutlist
</table>
";
}
else {
	$includes[content]="You do not have automatic payments turned on!";
}

?>