<?
$includes[title]="Resend Activation Email";

require("includes/class.phpmailer.php");
$mail = new phpmailer();


if($action == "resend") {
	$suc=send_act_email($uname);
	if($suc == 1) {
		$Db1->sql_close();
		header("Location: index.php?view=verify");
	}
	elseif($suc == 2) {
		$msg="<b style=\"red\">Your account is already active!</b>";
	}
	else {
		$msg="<b>ERROR!</b><br />There was an error sending your activation email.<br />Please contact us to have your account activated.";
	}
}


$includes[content]="
$msg
<form action=\"index.php?view=resend_act&action=resend\" method=\"post\">
Enter your username: <input type=\"text\" name=\"uname\"><br />
<input type=\"submit\" value=\"Resend Activation Code\">

<br /><br />
<div align=\"left\">
<b>Important!</b><br />
If you are using any sort of spam blocker or filters, please make sure that the email address $settings[admin_email] has persmission to send you email or you will not be able to activate your account! In most cases, adding <i>$settings[admin_email]</i> to your contact list will keep it from being blocked.
</div>

</form>
";
?>