<?
//**S**//
$void=0;
$void += substr_count($ac,"http");
$void += substr_count($ac,".com");
$void += substr_count($ac,"@");
$void += substr_count($ac,"ftp");
$void += substr_count($ac,":");
$void += substr_count($ac,".");
$void += substr_count($ac,"cgi");

if($void == 0) {
	if($ac == "") {
		$ac="membership";
	}
	include("members/$ac".".php");
}

else {
	echo "Possible Hack Attempt!";
	exit;
}
//**E**//
?>