<?
include("admin2/ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables, $thismemberinfo;


if($_REQUEST['delete'] == 1) {
	if($thismemberinfo['userid'] == $id) {
		echo "<div class=\"error\">You cannot delete your own account!</div>";
	}
	else {
		$Db1->query("DELETE FROM user WHERE userid='{$id}'");
		echo "<div class=\"success\">This account has been deleted!</div>";
	}
}

else {
?>
	<form action="#" method="POST" onsubmit="mm.deleteMember(); return false;">
		<input type="submit" value="Click Here To Delete This Member">
	</form>
<? } ?>