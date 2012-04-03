<?
include("ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables;

$newPwd = mysql_real_escape_string($_REQUEST['newPwd']);

if($_REQUEST['save'] == 1) {
	if(strlen($newPwd) < 3) {
		echo "<div class=\"error\">Password must be at least 3 characters! </div>";
	}
	else {
		$sql=$Db1->query("UPDATE user SET password='".md5($newPwd)."' WHERE userid='{$id}'");
		echo "<div class=\"success\">New password has been saved</div>";
	}
}


?>
	<form action="#" method="POST" onsubmit="mm.password_save(); return false;" id="vm_password_form">
		New Password: <input type="text" name="newPwd" value="">
		<input type="submit" value="Change Password">
	</form>
	