<?

requireAdmin();
global $url_variables;

function hault($error="") {
	global $Db1;
	echo "<p class=\"error\">{$error}</p>";
	$Db1->sql_close();
	exit;
}


if($_REQUEST['id']) {
	$id=mysql_real_escape_string($_REQUEST['id']);
	$q = "userid='{$id}'";
}
elseif($_REQUEST['uname']) {
	$uname=mysql_real_escape_string($_REQUEST['uname']);
	$q = "username='{$uname}'";
}
else {
	hault("There was an unexpected problem loading the requested user.");
}

$user=$Db1->query_first("SELECT * FROM user WHERE {$q}");
if(!$user) hault("The user could not be found in the database!");
if(!$id) $id=$user['userid'];

?>