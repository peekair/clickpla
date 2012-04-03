<?

//$settings['liberty_account']
//$settings['liberty_name']
//$settings['liberty_security']

//$_REQUEST['lr_orderid']


$xtra[name]=$_REQUEST["lr_paidby"];
$xtra[transaction_id]=$_REQUEST["lr_transfer"];
$xtra[account]=$_REQUEST["lr_paidby"];


$str =$_REQUEST["lr_paidto"].":".$_REQUEST["lr_paidby"].":".stripslashes($_REQUEST["lr_store"]).":".$_REQUEST["lr_amnt"].":".$_REQUEST["lr_transfer"].":".$_REQUEST["lr_currency"].":".$settings['liberty_security'];
$hash = strtoupper(bin2hex(mhash(MHASH_SHA256, $str)));

if (isset($_REQUEST["lr_paidto"]) &&
	$_REQUEST["lr_paidto"] == strtoupper($settings['liberty_account']) &&
	isset($_REQUEST["lr_store"]) &&
	stripslashes($_REQUEST["lr_store"]) == $settings['liberty_name'] &&
	isset($_REQUEST["lr_encrypted"]) &&
	$_REQUEST["lr_encrypted"] == $hash &&
	$_REQUEST["lr_amnt"] == $order['cost'] &&
	$_REQUEST["lr_currency"] == $settings[liberty_currency]
) { $VERIFIED=true; }


?>