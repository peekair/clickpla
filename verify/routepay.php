<?

global $settings;


$PAYMENT_ID			=$_POST['PAYMENT_ID'];
$rp_acc_merchant		=$_POST['rp_acc_merchant'];
$rp_amount			=$_POST['rp_amount'];
$rp_currency		=$_POST['rp_currency'];
$rp_batch		        =$_POST['rp_batch'];
$rp_acc_buyer			=$_POST['rp_acc_buyer'];
$$rp_merchant_ref      =$_POST['rp_merchant_ref'];

$rp_MD5			=$_POST['rp_MD5'];


$xtra[name]=$rp_acc_buyer;
$xtra[transaction_id]=$rp_batch;
$xtra[account]=$rp_acc_buyer;


	$passphrase=$settings[routepay_security];
	$mdpp =md5($passphrase);

	$hash1 = strtoupper(md5("$rp_acc_merchant:$rp_acc_buyer:$rp_amount:$rp_currency:$rp_merchant_ref:$rp_batch:$mdpp"));

  
	if($hash1 == $rp_MD5) {
		$result="VERIFIED";
	}
	else {
		$result="INVALID";
	}
	if($result == "VERIFIED") {
		$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$rp_batch'");
		if($rp_amount == $order['cost']) {
			if($Db1->num_rows() == 0) {
				$VERIFIED=true;
			}
		}
	}


?>