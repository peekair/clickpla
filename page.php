<?



if($type == 1) {
	$void=0;
	$void += substr_count($ac,"http");
	$void += substr_count($ac,".com");
	$void += substr_count($ac,"@");
	$void += substr_count($ac,"ftp");
	$void += substr_count($ac,":");
	$void += substr_count($ac,".");
	$void += substr_count($ac,"cgi");
	$void += substr_count($ac,"admin");
	$void += substr_count($ac,"members/");
	$void += substr_count($ac,"includes");
	if($void == 0) {
		include("$ac.php");
	}
	else {
		echo "Possible Hack Attempt!";
		exit;
	}
}
if($type == 2) {
	$sql=$Db1->query("SELECT * FROM templates WHERE id='$id'");
	if($Db1->num_rows() != 0) {
		$temp = $Db1->fetch_array($sql);
		if(($temp[login] == 0) || ($LOGGED_IN == true)) {
			if(($temp[premium] == 0) || ($thismemberinfo[type] == 1)) {
				if($temp[br] == 1) $temp[template] = nl2br($temp[template]);
				eval("\$includes[title]=\"".addslashes(stripslashes($temp[title]))."\";");
				eval("\$includes[content]=\"".addslashes(stripslashes($temp[template]))."\";");
				$Db1->query("UPDATE templates SET hits=hits+1, hits_today=hits_today+1 WHERE id='$id'");
			}
			else {
				$includes[title]="Access Denied";
				$includes[content]="You must be a premium member to view this page!";
			}
		}
		else {
			header("Location: index.php?view=login");
		}
	}
}

?>

<html>