<?
$id=$_GET['id'];
include("config.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
$id = mysql_real_escape_string($_REQUEST['id']);

$sql=$Db1->query("SELECT * FROM flinks WHERE id='$id'");
$flink=$Db1->fetch_array($sql);
$sql=$Db1->query("UPDATE flinks SET clicks=clicks+1 WHERE id='$id'");


header("Location: $flink[target]");

?>