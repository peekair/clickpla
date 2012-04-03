<?
$includes[title]="Account Filter Voider";

if($action == "void") {
	$sql=$Db1->query("SELECT * FROM payment_history WHERE username='$usern'");
	while($temp=$Db1->fetch_array($sql)) {
		$Db1->query("UPDATE payment_history SET ignore_filter='1' WHERE account='$temp[account]'");
	}
	$sql=$Db1->query("SELECT notes, suspended FROM user WHERE username='$usern'");
	$userr=$Db1->fetch_array($sql);
	if($userr[suspended] == 1) {
		$Db1->query("
		UPDATE user SET 
			suspended='0',
			notes='".addslashes(stripslashes(stripslashes($userr[notes])))."\n\nUnsuspended by account filter voider. '
			WHERE username='$usern'
		");
	}
	$includes[content]="$usern's account has been unsuspended and previous payments have been voided from the account filter.<br /><br />";
}

	$includes[content].="
	If you use the account filter to suspend an account and then you manually unsuspend their account, you must void their previous payments from the account filter or else they will be detected as a cheater again and be suspended yet again. This tool will also unsuspend the user's account entered.
	<br /><br />
	
	<form action=\"admin.php?view=admin&ac=ignore_filter&action=void&".$url_variables."\" method=\"post\">
	
	Username: <input type=\"text\" name=\"usern\">
	<input type=\"submit\" value=\"Void\">
	</form>
	
	";


?>
