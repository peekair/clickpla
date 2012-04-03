<?
//**S**//
$merchant_id 			=$HTTP_POST_VARS['merchant_id'];
$transaction_id 		=$HTTP_POST_VARS['transaction_id'];
$md5sig 				=$HTTP_POST_VARS['md5sig'];
$mb_amount 				=$HTTP_POST_VARS['mb_amount'];
$mb_currency			=$HTTP_POST_VARS['mb_currency'];
$status 				=$HTTP_POST_VARS['status'];

$amount 				=$HTTP_POST_VARS['amount'];

$xtra[name]=$pay_from_email;
$xtra[transaction_id]=$transaction_id;
$xtra[account]=$pay_from_email;

$security=strtoupper(md5($settings[mb_security]));

$hash1 = strtoupper(md5("$merchant_id$transaction_id$security$mb_amount$mb_currency$status"));

if(strtoupper($hash1) == strtoupper($md5sig)) {
	$result="VERIFIED";
}
else {
	$result="INVALID";
}

if($result == "VERIFIED") {
	if($amount == $order['cost']) {
		$VERIFIED=true;
	}
}
//**E**//
?>