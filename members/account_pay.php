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
$includes[title]="Purchase With Account Funds";
//**S**//
$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$order_id'");
if($Db1->num_rows() != 0) {
	$order=$Db1->fetch_array($sql);
	$includes[title]="Purchase $order[payment_id]";
	if($order[cost] <= $thismemberinfo[balance]) {
		$Db1->query("UPDATE user SET balance=balance-$order[cost] WHERE username='$username'");
		
		$Db1->query("INSERT INTO ledger SET
			payment_id='$order[order_id]',
			account='$username',
			product='$order[payment_id]',
			amount='$order[amount]',
			proc='".$procs[$order[proc]]."',
			dsub='".time()."',
			username='$order[username]',
			cost='$order[cost]',
			status='1'
		");
		$sql=$Db1->query("UPDATE orders SET paid='1' WHERE order_id='$order_id'");
		
		include("wizards/pfunctions.php");
		$Db1->sql_close();
		header("Location: index.php?view=thankyou&order_id=$order_id&".$url_variables."");
	}
	else {
		$includes[content]="You Do Not Have Sufficient Account Funds For This Purchase!";
	}
}
else {
	$includes[content]="There Was An Error Completing This Transaction! Please Try Again";
}
//**E**//
?>