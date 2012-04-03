<?
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include("includes/globals.php");


$sql=$Db1->query("SELECT * FROM banners WHERE credits>=1 order by rand() limit 1");
$pagebanner468=$Db1->fetch_array($sql);
$sql=$Db1->query("UPDATE banners SET credits=credits-1, views=views+1 WHERE id='$pagebanner468[id]'");

$Db1->sql_close();

echo "document.write(\"<a href='$settings[base_url]/bannerclick.php?id=$pagebanner468[id]' target='_blank'><img src='$pagebanner468[banner]' border=0' width='468' height='60'></a>\");";

?>