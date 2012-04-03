<?
//**S**//
$vip=getenv("REMOTE_ADDR");

$xtra[name]=$_POST['ap_custfirstname'];
$xtra[transaction_id]=$_POST['ap_referencenumber'];
$xtra[account]=$_POST['ap_custemailaddress'];


$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='".$_POST['ap_referencenumber']."'");
if($Db1->num_rows() > 0) {
	$Db1->sql_close();
	exit;
}

if(
	($_POST['ap_securitycode'] != trim($settings['alertpay_code']) ) ||
	($_POST['ap_currency'] != "USD") ||
	($_POST['ap_status'] != "Success") ||
	($_POST['ap_referencenumber'] == "") ||
	($_POST['ap_amount'] != $order['cost']) 
	|| ($_POST['ap_test'] != 0 )
) {
	$VERIFIED=false;
	$Db1->sql_close();
}
else {
	$VERIFIED=true;
}


//**E**//


?>