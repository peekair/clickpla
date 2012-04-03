<?
//**VS**//$setting[ptr]//**VE**//
$includes[title]="Paid Email View [Timer]";
include("config.php");
include("includes/functions.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include("includes/globals.php");

//**S**//
if($userid != "") {$uid=$userid;}

$sql=$Db1->query("SELECT * FROM banners WHERE credits>=1 and active=1 ".iif($LOGGED_IN==true," and username!='$user'")." order by rand() limit 1");
$pagebanner468=$Db1->fetch_array($sql);
$sql=$Db1->query("UPDATE banners SET credits=credits-1, views=views+1 WHERE id='$pagebanner468[id]'");


$sql=$Db1->query("SELECT * FROM email_browseval WHERE dsub='$pretime' and username='$user'");
$temp=$Db1->fetch_array($sql);
$key=$temp[val];

srand ((float) microtime() * 10000000);
$buttons = array ("1", "2", "3", "4", "5", "6", "7", "8", "9");
$rand_keys = array_rand ($buttons, 4);


$key = $buttons[$rand_keys[$key]];

for($x=0; $x<4; $x++) {
	$buttonlist.="<a href=\"#\" onclick=\"next($x)\" id=\"button$x\"><img src=\"clickimages/".$buttons[$rand_keys[$x]].".gif\" border=0></a>";
}

$sql=$Db1->query("SELECT * FROM emails WHERE id='$id'");
$ad=$Db1->fetch_array($sql);

$Db1->sql_close();
//**E**//
$timercode="
		<td>
			<font size=\"3\"><div align=\"center\" id=\"timer\">Loading...</div></font>
			$buttonlist
		</td>
";

$thebannercode="<td><a href=\"bannerclick.php?id=$pagebanner468[id]\" target=\"_blank\"><img src=\"$pagebanner468[banner]\" border=0\" width=\"468\" height=\"60\"></a></td>";

echo "
<html>
<head>
<style>
body {
	margin: 0 0 0 0;
}
a {
	text-decoration: none;
	color: blue;
}
</style>
</head>
<body bgcolor=\"white\">
<script>
function next(num) {
	if(x == 0) {parent.location.href='pemailfinal.php?button_clicked='+num+'&id=$id&pretime=$pretime&user=$user&".$url_variables."';}
	else {
		alert(\"You must wait for the counter to reach 0\");
	}
}

x=".($settings[ptr_time]+1).";

function change_content(obj, num) {
	if (document.getElementById) {el = document.getElementById(obj) ;}
	else if (document.all){	el = document.all[obj]; }
	else if (document.layers) {el = document.layers[obj];}
	el.innerHTML = \"<b>\"+num+\"</b>\";
}


function timer() {
x--;
if(x == 0) {var show=\"Click $key\";}
else {
	var show=x;
	setTimeout('timer()', 1000);
}
change_content('timer', show)
}
</script>
<div align=\"center\">

<table>
	<tr>
		".iif($key%2,$thebannercode."<td width=30></td>".$timercode,$timercode."<td width=30></td>".$thebannercode)."
		
	</tr>
</table>

</div>

<script>
timer()
</script>
</body>
</html>
";
exit;
?>