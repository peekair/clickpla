<?
$sql=$Db1->query("SELECT * FROM user WHERE username='".addslashes($uname)."'");
if($Db1->num_rows() == 0) {
	$Db1->sql_close();
	header("Location: index.php?view=login&".$url_variables."");
	exit;
}

$includes[content]="
Welcome To $settings[domain_name] $uname!<br /><br />
Referral url: http://www.$settings[domain_name]/index.php?ref=$uname<br />
Login Url: http://www.$settings[domain_name]/index.php<br />


";
?>
