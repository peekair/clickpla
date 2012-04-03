<?
$includes[title]="Verify Email To Activate Account";


if(($action == "verify") && ($id != "")) {
	$sql=$Db1->query("SELECT * FROM user WHERE verify_id='$id' and username='$user'");
	if($Db1->num_rows() != 0) {
		$user=$Db1->fetch_array($sql);
		$sql=$Db1->query("UPDATE user SET verified='1', verify_id='' WHERE username='$user[username]'");

			$mm="
Hello $user[username],
Your account has now been activated; Welcome to $settings[site_title]!


****************************
**Registration Information**
****************************
Username:$user[username]
Login Url: http://www.$settings[domain_name]/index.php
Referral url: http://www.$settings[domain_name]/index.php?ref=$user[username]


-$settings[domain_name] Admin

************************************************************
You are receiving this email because this email address was
supplied during registration at $settings[domain_name]. If you
did not register an account here, please login using the details
above and delete the account under 'profile'
************************************************************";
		$from="$settings[domain_name] Admin <$settings[admin_email]>";
		$to = "$user[email]";
		$headers = "From: $from\r\n" . "Reply-To: $from\r\n" . "X-Mailer: Php";
		$subject="Welcome To $settings[domain_name]!";
		@mail($to,$subject,$mm,$headers);
		$Db1->sql_close();
		header("Location: index.php?view=welcome&uname=$user[username]");
	}
	else {
		$includes[content]="<b style=\"color:red\">Your username and activation code did not match. Please try again or have a new activation email sent to you.</b>";
	}
}
if (($action == "verify") && ($id == "")) {
	$includes[content]="<b style=\"color:red\">There was an error. Please re enter your information.</b>";
}

$includes[content].="
<form action=\"index.php?view=verify&action=verify\" method=\"post\">
An email was sent to your inbox with an activation code inside. Please enter your username and the activation code below to activate your account.<br />
Username: <input type=\"text\" name=\"user\" value=\"$user\"><br />
Activation Code: <input type=\"text\" name=\"id\" value=\"$id\"><br />

<input type=\"submit\" value=\"Activate Account\">
</form>

<li><a href=\"index.php?view=resend_act\">Resend Activation Code</a>
<li><a href=\"index.php?view=update_email\">Change My Email Address</a>

<br /><br />
<div align=\"left\">
<b>Important!</b><br />
If you are using any sort of spam blocker or filters, please make sure that the email address $settings[admin_email] has persmission to send you email or you will not be able to activate your account! In most cases, adding <i>$settings[admin_email]</i> to your contact list will keep it from being blocked.
</div>



";
?>