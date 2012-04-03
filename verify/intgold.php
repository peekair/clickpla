<?
//**S**//


$VERIFIED=false;
$xtra[name]=$BUYERACCOUNTID;
$xtra[transaction_id]=$TRANSACTION_ID;
$xtra[account]=$BUYERACCOUNTID;


$passphrase=strtoupper(md5($settings[intgold_second]));


if($RESULT == 0) {
//if(true) { // TEST!
	if(strtoupper($HASH) == strtoupper($passphrase)) 	$result="VERIFIED";
	else 				$result="INVALID";
}
else {
	$result="INVALID";
}


if($result == "VERIFIED") {
	$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$TRANSACTION_ID'");
	if($AMOUNT == $order['cost']) {
		if($Db1->num_rows() == 0) {
			$VERIFIED=true;
		}
	}
}
//**E**//
?>


