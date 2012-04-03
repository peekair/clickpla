<?

global $settings;


$PAYMENT_ID			=$_POST['PAYMENT_ID'];
$PAYEE_ACCOUNT			=$_POST['PAYEE_ACCOUNT'];
$PAYMENT_AMOUNT			=$_POST['PAYMENT_AMOUNT'];
$PAYMENT_CURRENCY		=$_POST['PAYMENT_UNITS'];
$PAYMENT_BATCH_NUM	        =$_POST['PAYMENT_BATCH_NUM'];
$PAYER_ACCOUNT			=$_POST['PAYER_ACCOUNT'];
$TIMESTAMPGMT			=$_POST['TIMESTAMPGMT'];

$V2_HASH			=$_POST['V2_HASH'];



$xtra[name]=$PAYER_ACCOUNT;
$xtra[transaction_id]=$PAYMENT_BATCH_NUM;
$xtra[account]=$PAYER_ACCOUNT;


	$passphrase=$settings[perfectm_security];
	$mdpp =md5($passphrase);
	$hash1 = strtoupper(md5("$PAYMENT_ID:$PAYEE_ACCOUNT:$PAYMENT_AMOUNT:$PAYMENT_UNITS:$PAYMENT_BATCH_NUM:$PAYER_ACCOUNT:$mdpp:$TIMESTAMPGMT"));

  
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

?>