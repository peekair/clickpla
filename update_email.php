<?
$includes[title]="Update Your Email Address";

if($action == "update") {
	$sql=$Db1->query("SELECT * FROM user WHERE username='$form_username'");
	if($user=$Db1->fetch_array($sql)) {
		if($user[password] == $form_pwd) {
			$sql=$Db1->query("SELECT userid FROM user WHERE email='$form_email' and username!='$form_username'");
			if($Db1->num_rows() == 0) {
				$Db1->query("UPDATE user SET 
								verified='0',
								email='".addslashes($form_email)."'
							WHERE username='$form_username'");
				if(send_act_email($form_username) == 1) {
					$Db1->sql_close();
					header("Location: index.php?view=verify");
				}
				else {
					$msg="<b>ERROR!</b><br />There was a fatal error.";
				}
			}
			else {
				$msg="<b>ERROR!</b><br />The email address you entered is already being used by another account.";
			}
		}
		else {
			$msg="<b>ERROR!</b><br />The password you entered does not match our records. If you feel this is an error, please contact us.";
		}
	}
	else {
		$msg="<b>ERROR!</b><br />Your account was not found in our database. Please contact us if this in an error.";
	}
}


$includes[content]="
If you are having trouble receiving email from us containing your activation code and/or password, please use this form to change your email address to an alternate email account.<br />
<font color=\"darkred\">$msg</font>
<form action=\"index.php?view=update_email&action=update\" method=\"post\">
Your username: <input type=\"text\" name=\"form_username\"><br />
Your password: <input type=\"password\" name=\"form_pwd\"><br />
Your new email address: <input type=\"text\" name=\"form_email\"><br />
<input type=\"submit\" value=\"Update My Email Address\">

<br /><br />
<div align=\"left\">
<b>Important!</b><br />
If you are using any sort of spam blocker or filters, please make sure that the email address $settings[admin_email] has persmission to send you email or you will not be able to activate your account! In most cases, adding <i>$settings[admin_email]</i> to your contact list will keep it from being blocked.
</div>

</form>
";
?>