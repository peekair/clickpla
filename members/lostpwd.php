<?
//##############################################
//#            AURORAGPT Script Copyright owned by Mike Pratt              #
//#                        ALL RIGHTS RESERVED 2007-2009                        #
//#                                                                                                 #
//#        Any illegal use of this script is strictly prohibited unless          # 
//#        permission is given by the owner of this script.  To sell          # 
//#        this script you must have a resellers license. Your site          #
//#        must also use a unique encrypted license key for your         #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise         #
//#        it will be considered as unlicensed and can be shut down    #
//#        legally by Illusive Web Services. By using AuroraGPT       #
//#        script you agree not to copy infringe any of the coding     #
//#        and or create a clone version is also copy infringement   #
//#        and will be considered just that and legal action will be   #
//#        taken if neccessary.                                                    #
//#########################################//   
if($action == "recover") {
	$sql=$Db1->query("SELECT * FROM user WHERE username='$form_user'");
	if($Db1->num_rows() != 0) {
		$newpwd = rand_string(10);
		$Db1->query("UPDATE user SET password='".md5($newpwd)."' WHERE username='$form_user'");
		$user=$Db1->fetch_array($sql);
		$msg="Hello $user[name]
Your password has been reset per your request at $settings[domain_name]:

Username: $user[username]
Password: $newpwd

The ip address that requested this password is: $vip

If you did not request this password, please change your password immediately and contact us.";
		$subject="You password for $settings[domain_name]";
		send_mail($user[email],$user[name],$subject,$msg);
		$includes[content]="Your password has been sent to your email.";
	}
	else {$includes[content]="There was an error finding your account in the database.";}
}
else {
$includes[content]="
<form action=\"index.php?view=lostpwd&action=recover&".$url_variables."\" method=\"post\">
Use the following form to have your password reset and sent via the email address you used to register.
Enter your username: <input type=\"text\" name=\"form_user\"><br />
<input type=\"submit\" value=\"Recover Password\">
</form>
";
}
?>
