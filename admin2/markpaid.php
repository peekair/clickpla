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
$includes[title]="Payouts Manager Main";

else{
	$sql=$Db1->query("SELECT * FROM payouts WHERE id='$id' ORDER BY id DESC LIMIT 1");
	$selpayout=$Db1->fetch_array($sql);
}

	$sql=$Db1->query("SELECT * FROM requests WHERE id='$pid'");
	$selpayout=$Db1->fetch_array($sql);
	$sql=$Db1->query("UPDATE payment_history SET status='2', paid='".time()."' WHERE payout_id='$selpayout[payout_id]'");
	$sql=$Db1->query("UPDATE requests SET paid='2' WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=markpaid&id=$pid&".$url_variables."");

$includes[content].="

<center>
PAID!</center>

";
?>