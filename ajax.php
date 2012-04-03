<?
include("./header.php");

function requireAdmin() {
	global $permission, $Db1;
	if ($permission != 7) {
		echo "Permission Denied!";
		$Db1->sql_close();
		exit;
	}
}


if((isBadUrl($action) > 0) || (isBadUrl($resource) > 0)) {
	echo "Error!";
	$Db1->sql_close();
	exit;
}




include("ajax_php/".$resource."/".$action.".php");

$Db1->sql_close();
exit;
?>