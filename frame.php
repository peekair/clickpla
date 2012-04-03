<?
include("header.php");

$sql = $Db1->query("SELECT * FROM $type WHERE id='$id'");
$site=$Db1->fetch_array($sql);

?>

<html>
<head>
<script>
var openid=<? echo $openid; ?>;

function approve() {
	opener.location.href='javascript: approve('+openid+')';
	window.close();
}
function deny() {
	opener.location.href='javascript: deny('+openid+')';
	window.close();
}
</script>
</head>
<frameset rows="73,*" cols="100%" style="border: 1 black;" noresize="noresize">
<frame name="topframe" src="verifytop.htm" scrolling=no marginheight="2" marginwidth="2" noresize="noresize" >
<frame name="mainframe" src="<? echo $site[target]; ?>" marginheight="0" marginwidth="0" noresize="noresize">
</frameset>
</html>