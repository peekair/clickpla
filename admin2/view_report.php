<?
//##############################################
//#            AURORAGPT Script Copyright owned by Mike Pratt              #
//#                        ALL RIGHTS RESERVED 2007-2009                        #
//#                                                                                                 #
//#        Any illegal use of this script is strictly prohibited unless          # 
//#        permission is given by the owner of this script.  To sell          # 
//#        this script you must have a resellers license. Your site          #
//#        must also use a unique encrypted license key for your         #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise         #
//#        it will be considered as unlicensed and can be shut down    #
//#        legally by Illusive Web Services. By using AuroraGPT       #
//#        script you agree not to copy infringe any of the coding     #
//#        and or create a clone version is also copy infringement   #
//#        and will be considered just that and legal action will be   #
//#        taken if neccessary.                                                    #
//#########################################//  

$type=$_GET['type'];
$adid=$_GET['adid'];

$adTables = array(
"ptc"=>"ads",
"ptre"=>"emails",
"ptra"=>"ptrads",
"ce"=>"xsites"
);
$creditTables = array(
"ptc"=>"link_credits",
"ptre"=>"ptr_credits",
"ptra"=>"ptra_credits",
"ce"=>"xcredits"
);

if(isset($_POST['submit'])){

	$placed_by = $Db1->querySingle("SELECT placed_by FROM reports WHERE adid='$adid'","placed_by");

	switch($action){
		case "suspend";
			$sql=$Db1->query("DELETE FROM ".$adTables[$type]." WHERE id='$adid'");
			$sql=$Db1->query("DELETE FROM reports WHERE adid='$adid'");
			$sql=$Db1->query("UPDATE user SET suspended='1' WHERE username='$placed_by'");
		break;

		case "dismiss";
			$sql=$Db1->query("DELETE FROM reports WHERE adid='$adid'");
		break;

		case "delete_ad";
			if($_POST['refund']=="on"){
				$refund_credits = $Db1->querySingle("SELECT credits FROM ".$adTables[$type]." WHERE id='$adid'","credits");
				$sql=$Db1->query("UPDATE user SET {$creditTables[$type]}={$creditTables[$type]}+{$refund_credits} WHERE username='$placed_by'");
			}
			$sql=$Db1->query("DELETE FROM reports WHERE adid='$adid'");
			$sql=$Db1->query("DELETE FROM ".$adTables[$type]." WHERE id='$adid'");
		break;
	};

	header("Location: admin.php?view=admin&ac=reports&action=save&{$url_variables}");
	exit();
}else{

	$sql=$Db1->query("SELECT * FROM reports WHERE adid='$adid'");
	while($report=$Db1->fetch_array($sql)){

		$includes[content].="<b>Ad Title: </b>{$report['title']}<br \>
<b>Ad Target: </b><a href=\"{$report['target']}\" target=\"_blank\">{$report['target']}</a><br \>
<b>Placed By: </b>{$report['placed_by']}<br \>
<b>Number of Reports Made: </b>{$report['reports']}<br \><br \><small>Note: The reported page may appear differently to you depending on your settings (popup blocker, different browser).</small><br \><b>Options:</b><br \>";
		$username_list=explode("::",$report['username']);
		$reason_list=explode("::",$report['reason']);
		$other_list=explode("::",$report['other']);

		$buttons="<form action=\"admin.php?view=admin&ac=view_report&adid={$adid}&type={$report['type']}&action=delete_ad&$url_variables\" method=\"POST\">Refund Remaining Credits:<input type=\"checkbox\" name=\"refund\"><br \>
<input type=\"submit\" value=\"Delete Ad\" name=\"submit\"></form>
<form action=\"admin.php?view=admin&ac=view_report&adid={$adid}&type={$report['type']}&action=suspend&$url_variables\" method=\"POST\"><input type=\"submit\" value=\"Suspend User and Delete Ad\" name=\"submit\"></form>
<form action=\"admin.php?view=admin&ac=view_report&adid={$adid}&type={$report['type']}&action=dismiss&$url_variables\" method=\"POST\"><input type=\"submit\" value=\"Dismiss Report\" name=\"submit\"></form>";

		$includes[content].=$buttons;
		$i=0;
		while($i<(count($reason_list))){

			$includes[content].="<b>Report By:</b> {$username_list[$i]}<br \>
<b>Reason:</b> {$reason_list[$i]}<br \>
<b>Other Info:</b> {$other_list[$i]}<br \><br \>";
			$i++;

		}

	}//end while($report=$Db1->fetch_array($sql))


}//end if(isset($_POST['submit']))


?>


