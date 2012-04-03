<?
include("header.php");

if($action == "vote") {
	$sql=$Db1->query("SELECT * FROM poll_history WHERE ip='$vip'");
	if($Db1->num_rows() == 0) {
		if($settings[poll_votes] == "") $settings[poll_votes]="0:0:0:0:0";
		$ptemp=explode(":",$settings[poll_votes]);
		for($x=0; $x<5; $x++) {
			if($ptemp[$x] == "") {
				$ptemp[$x]="0";
			}
			$pollresults[$x+1]=$ptemp[$x];
		}
		$pollresults[$pollres]+=1;
		$newvotes=implode(":",$pollresults);
		$sql=$Db1->query("INSERT INTO poll_history SET ip='$vip'");
		$settings["poll_votes"] = 	"$newvotes";
		include("admin2/settings/update.php");
		updatesettings($settings);
	}
}

header("Location: index.php?".$url_variables."");

$Db1->sql_close();
?>