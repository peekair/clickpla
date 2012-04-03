<?
// Prevention of XSS attack via $_GET. foreach ($_GET as $check_url) { if ((eregi("<[^>]*script*\"?[^>]*>", $check_url)) || (eregi("<[^>]*object*\"?[^>]*>", $check_url)) || (eregi("<[^>]*iframe*\"?[^>]*>", $check_url)) || (eregi("<[^>]*applet*\"?[^>]*>", $check_url)) || (eregi("<[^>]*meta*\"?[^>]*>", $check_url)) || (eregi("<[^>]*style*\"?[^>]*>", $check_url)) || (eregi("<[^>]*form*\"?[^>]*>", $check_url)) || (eregi("\([^>]*\"?[^)]*\)", $check_url)) || (eregi("\"", $check_url))) { die (); } } unset($check_url);


//putenv("TZ=US/Eastern");
$filename = 'install';
$filename2 = 'install/';

if(file_exists($filename) && is_dir($filename)) {
    echo "Please delete the Install directory to continue";
    exit;
    }

	if($dbg == 1) {
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;
		$mtimetemp = explode(" ",microtime());
		$lasttime = $mtimetemp[1] + $mtimetemp[0];
	}

include("./header.php");

	if($dbg == 1) {
		$mtimetemp = explode(" ",microtime());
		$lasttimetemp = $mtimetemp[1] + $mtimetemp[0];
		$thistime=$lasttimetemp-$lasttime;
		$lasttime=$lasttimetemp;
		$debug.="<tr><td width=100>Header:</td><td>".round($thistime,5)."</td></tr>";
	}


include("./includes/modules.php");

	if($dbg == 1) {
		$mtimetemp = explode(" ",microtime());
		$lasttimetemp = $mtimetemp[1] + $mtimetemp[0];
		$thistime=$lasttimetemp-$lasttime;
		$lasttime=$lasttimetemp;
		$debug.="<tr><td>Modules:</td><td>".round($thistime,5)."</td></tr>";
	}




if(($LOGGED_IN) && ($settings[footprints] == 1)) {
	$temp=parse_url($REQUEST_URI);
	$theurl=$temp[path]."?".
			iif($view!="","view=$view&").
			iif($ac!="","ac=$ac&").
			iif($id!="","id=$id&").
			iif($user!="","user=$user&").
			iif($ref!="","ref=$ref&").
			iif($action!="","action=$action&");
	if($theurl != "") {
		$Db1->query("INSERT INTO footprints SET
			username='$username',
			dsub='".time()."',
			url='".$theurl."',
			uri='".$REQUEST_URI."',
			title='".$includes[title]."',
			ip='$vip'
		");
	}
}


if(is_file("templates/$settings[template]/layout_header.php") == true) include("templates/$settings[template]/layout_header.php");
else include("./includes/layout_header.php");


	if($dbg == 1) {
		$mtimetemp = explode(" ",microtime());
		$lasttimetemp = $mtimetemp[1] + $mtimetemp[0];
		$thistime=$lasttimetemp-$lasttime;
		$lasttime=$lasttimetemp;
		$debug.="<tr><td>Banners:</td><td>".round($thistime,5)."</td></tr>";
	}

if(($LOGGED_IN == true) && ($thismemberinfo[type]==1)) {
	$sql=$Db1->query("SELECT * FROM memberships WHERE id='$thismemberinfo[membership]'");
	$tempt=$Db1->fetch_array($sql);
	$thetype=$tempt[title];
}

$Db1->sql_close();

include("./templates/$settings[template]/layout.php");

	if($dbg == 1) {
		$mtimetemp = explode(" ",microtime());
		$lasttimetemp = $mtimetemp[1] + $mtimetemp[0];
		$thistime=$lasttimetemp-$lasttime;
		$lasttime=$lasttimetemp;
		$debug.="<tr><td>Template:</td><td>".round($thistime,5)."</td></tr>";
	}



if($dbg == 1) {
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);
	echo "<br /><br />
		<div align=\"center\">
		<table style=\"color: black;\">
			".$debug."
			<tr>
				<td colspan=2 height=1 bgcolor=\"black\"></td>
			</tr>
			<tr>
				<td>Total Time:</td>
				<td>".round($totaltime,5)."</td>
			</tr>
		</table>
		</div>
		";
	flush();
}
exit;
?>