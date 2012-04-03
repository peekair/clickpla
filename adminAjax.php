<?
include("./header.php");

$resource = $_REQUEST['resource'];
$action = $_REQUEST['action'];

function requireAdmin() {
	global $permission, $Db1;
	if ($permission != 7) {
		echo "Permission Denied!";
		$Db1->sql_close();
		exit;
	}
}


if((isBadUrl($action) == 0) && (isBadUrl($resource) == 0)) {
	include("admin2/ajax_php/".$resource."/".$action.".php");
} else {
	echo "error";
}

$Db1->sql_close();

?>