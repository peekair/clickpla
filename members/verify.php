<?


			$mm="
Hello $form_username,
Welcome to $settings[domain_name]!

****************************
**Registration Information**
****************************
Username:$form_username
Password: $form_password
Login Url: http://www.$settings[domain_name]/index.php
Referral url: http://www.$settings[domain_name]/index.php?ref=$form_username


-$settings[domain_name] Admin

************************************************************
You are receiving this email because this email address was
supplied during registration at $settings[domain_name]. If you did
not register an account here, please login using the details
above and delete the account under 'profile'
************************************************************";
			$from="$settings[domain_name] Admin <$settings[admin_email]>";
			$to = "$form_email";
			$headers = "From: $from\r\n" . "Reply-To: $from\r\n" . "X-Mailer: Php";
			$subject="Welcome To $settings[domain_name] -- Action Required!";
			@mail($to,$subject,$mm,$headers);
?>