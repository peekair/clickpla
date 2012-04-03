<?
include("ajax_php/memberManager/header.php");
global $user, $id, $settings, $url_variables, $thismemberinfo;


if($_REQUEST['tag'] == true) {
	$tagg = 1;
}
else $tagg=0;

$Db1->query("UPDATE user SET tagged='$tagg' WHERE userid='$id'");

?>