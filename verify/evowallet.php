<?
//////////Defining gloabl settings array/////////////
global $settings;
//**S**//
$PAYMENT_ID				=$_POST['PAYMENT_ID'];
$PAYEE_ACCOUNT			=$_POST['PAYEE_ACCOUNT'];
$PAYMENT_AMOUNT			=$_POST['PAYMENT_AMOUNT'];
$PAYMENT_CURRENCY		=$_POST['PAYMENT_CURRENCY'];
$PAYMENT_BATCH		=$_POST['PAYMENT_BATCH'];
$PAYER_ACCOUNT			=$_POST['PAYER_ACCOUNT'];
$TIMESTAMP			=$_POST['TIMESTAMP'];
$V1_HASH				=$_POST['V1_HASH'];




$xtra[name]=$PAYER_ACCOUNT;
$xtra[transaction_id]=$PAYMENT_BATCH;
$xtra[account]=$PAYER_ACCOUNT;



	$passphrase=$settings[evo_second];
	$mdpp =md5($passphrase);
	$hash1 = strtoupper(md5("$PAYER_ACCOUNT:$PAYEE_ACCOUNT:$PAYMENT_AMOUNT:$PAYMENT_CURRENCY:$PAYMENT_BATCH:$TIMESTAMP:$mdpp"));
  
	if($hash1 == $V1_HASH) {
		$result="VERIFIED";
	}
	else {
		$result="INVALID";
	}

	if($result == "VERIFIED") {
		$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$PAYMENT_BATCH'");
		if($PAYMENT_AMOUNT == $order['cost']) {
			if($Db1->num_rows() == 0) {
				$VERIFIED=true;
			}
		}
	}

//**E**//
?>

