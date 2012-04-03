<?
//**S**//
$TXN_ID 				=$_POST['TXN_ID'];
$PAYMENT_AMOUNT			=$_POST['PAYMENT_AMOUNT'];
$PAYER_ACCOUNT			=$_POST['PAYER_ACCOUNT'];
$PAYEE_ACCOUNT			=$_POST['PAYEE_ACCOUNT'];
$MEMO					=$_POST['MEMO'];
$EXTRA_INFO				=$_POST['EXTRA_INFO'];
$PAYMENT_BATCH_NUM		=$_POST['PAYMENT_BATCH_NUM'];
$TIMESTAMP				=$_POST['TIMESTAMP'];

$SECURITY_ANSWER=$settings[netpay_security];

$xtra[name]=$PAYER_ACCOUNT;
$xtra[transaction_id]=$PAYMENT_BATCH_NUM;
$xtra[account]=$PAYER_ACCOUNT;

$hash1 = strtoupper(md5("$PAYMENT_AMOUNT:$PAYER_ACCOUNT:$PAYEE_ACCOUNT:$MEMO:$EXTRA_INFO:$SECURITY_ANSWER:$TXN_ID:$PAYMENT_BATCH_NUM:$TIMESTAMP"));

if($hash1 == $MD5_DIGEST) {
	$result="VERIFIED";
}
else {
	$result="INVALID";
}

if($result == "VERIFIED") {
	if($PAYMENT_AMOUNT == $order['cost']) {
		$VERIFIED=true;
	}
}
//**E**//
?>


