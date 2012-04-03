<?
//**S**//
if($secret_code == $settings[stormpay_secret]) {
	if($amount == $order[cost]) {
		if($status == "SUCCESS") {
			$VERIFIED=true;
			$xtra[name]=$payer_name;
			$xtra[transaction_id]=$transaction_id;
			$xtra[account]=$payer_email;
		}
	}
}
else {
	mail($settings[admin_email],"StormPay IPN Failed!","
	This is an automated message you let you know that there was a stormpay payment at $settings[site_title] which failed because you do not have the correct 'secret code' set in your payment settings.

Actual Secret Code: $secret_code
Registered Code: $settings[stormpay_secret]

","From: $settings[admin_email]");
}
//**E**//
?>
