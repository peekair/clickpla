<?
//this is the "fake" router! For those bots who look for route.php....

require_once "includes/routing.php";
$spam = new AntiSpam();
$chars = $spam->Rand(5);

if( $spam->Stroke() === false ) {
	header("Location: images/gderror.gif");
	//die('Illegal or no data to plot');
}



?>