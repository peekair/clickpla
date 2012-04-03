<?
include("includes/functions.php");
require_once "includes/routing.php";


//$chars = $spam->Rand(5);

	include("config.php");
	include("includes/mysql.php");
	$Db1 = new DB_sql;
	$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
	$sql=$Db1->query("SELECT * FROM route_codes WHERE id='$rid'");
	$temp=$Db1->fetch_array($sql);
	$num=$temp[code];
	$Db1->sql_close();


$spam = new AntiSpam("$num");



if( $spam->Stroke() === false ) {
	header("Location: images/gderror.gif");
	//die('Illegal or no data to plot');
}



?>