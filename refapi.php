<?
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);

include("includes/globals.php");

// $username
// $access = md5(password)

$sql=$Db1->query("SELECT password FROM user WHERE username='$username'");
$user=$Db1->fetch_array($sql);

if(md5($user[password]) == $access) {
	$sql = $Db1->query("SELECT username FROM user WHERE refered='$username'");
	$total=$Db1->num_rows();
	for($x=1; $temp = $Db1->fetch_array($sql); $x++) {
		$list.="$temp[username]";
		if($x < $total) {$list.="\n";}
	}
	echo $list;
}
else {
	echo "Invalid Access!";
}

$Db1->sql_close();
?>