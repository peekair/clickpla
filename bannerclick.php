<?
$id=$_GET[id];

include("config.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);

$sql=$Db1->query("SELECT * FROM banners WHERE id='$id'");
$banner=$Db1->fetch_array($sql);
$sql=$Db1->query("UPDATE banners SET clicks=clicks+1 WHERE id='$id'");

$Db1->sql_close();

header("Location: $banner[target]");
exit;
?>
