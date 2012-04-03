<?
$vip=getenv("REMOTE_ADDR");
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);

include("includes/sessions.php");

$sql = $Db1->query("DELETE FROM sessions WHERE user_id = '$userid'");

setcookie("c_sid", "",time()+1); 
setcookie("c_sid2", "",time()+1); 
setcookie("c_siduid", "",time()+1); 

$Db1->sql_close();

header("Location: index.php");
?>