<?
//**S**//
$PAYMENT_ID				=$_POST['PAYMENT_ID'];
$PAYEE_ACCOUNT			=$_POST['PAYEE_ACCOUNT'];
$PAYMENT_AMOUNT			=$_POST['PAYMENT_AMOUNT'];
$PAYMENT_UNITS			=$_POST['PAYMENT_UNITS'];
$PAYMENT_METAL_ID		=$_POST['PAYMENT_METAL_ID'];
$PAYMENT_BATCH_NUM		=$_POST['PAYMENT_BATCH_NUM'];
$PAYER_ACCOUNT			=$_POST['PAYER_ACCOUNT'];
$ACTUAL_PAYMENT_OUNCES	=$_POST['ACTUAL_PAYMENT_OUNCES'];
$USD_PER_OUNCE			=$_POST['USD_PER_OUNCE'];
$FEEWEIGHT				=$_POST['FEEWEIGHT'];
$TIMESTAMPGMT			=$_POST['TIMESTAMPGMT'];
$MEMBERID				=$_POST['MEMBERID'];
$ITEM_ID				=$_POST['ITEM_ID'];
$V2_HASH				=$_POST['V2_HASH'];
$TYPE					=$_POST['TYPE'];
$ITEM_MBR_TYPE			=$_POST['ITEM_MBR_TYPE'];


$xtra[name]=$PAYER_ACCOUNT;
$xtra[transaction_id]=$PAYMENT_BATCH_NUM;
$xtra[account]=$PAYER_ACCOUNT;

if($PAYMENT_UNITS != 1) {
	$Db1->sql_close();
	exit;
}
else {
	$passphrase=$settings[egold_second];
	$mdpp = strtoupper(md5($passphrase));
	$hash1 = strtoupper(md5("$PAYMENT_ID:$PAYEE_ACCOUNT:$PAYMENT_AMOUNT:$PAYMENT_UNITS:$PAYMENT_METAL_ID:$PAYMENT_BATCH_NUM:$PAYER_ACCOUNT:$mdpp:$ACTUAL_PAYMENT_OUNCES:$USD_PER_OUNCE:$FEEWEIGHT:$TIMESTAMPGMT"));
	if($hash1 == $V2_HASH) {
		$result="VERIFIED";
	}
	else {
		$result="INVALID";
	}

	if($result == "VERIFIED") {
		$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$PAYMENT_BATCH_NUM'");
		if($PAYMENT_AMOUNT == $order['cost']) {
			if($Db1->num_rows() == 0) {
				$VERIFIED=true;
			}
		}
	}
}
//**E**//
?>


