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

include("./includes/settings.php");
$bog = $settings[bog_amount];
$amount = doubleval($amount);
if($amount < 0) {
	$amount=0;
}
if(!isset($pid)) {
	while(!isset($pid)) { //make sure a unique order_id gets generated!
		$temppid=rand_string(10);
		$Db1->query("SELECT order_id FROM orders WHERE order_id='$temppid'");
		if($Db1->num_rows() == 0) {
			$pid = $temppid;
		}
	}

	$sql=$Db1->query("INSERT INTO orders SET
		order_id='".addslashes($pid)."',
		username='".addslashes($username)."',
		ad_type='".addslashes($ptype)."',
		dsub='".time()."',
		premium_id='".addslashes($id)."',
		special_id='".addslashes($id)."'
	");
	$sql=$Db1->sql_close();

	header("Location: index.php?view=account&ac=buywizard&step=2".iif($samount, "&samount=$samount")."&pid=$pid&".$url_variables."");
}

$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$pid' and username='$username' and paid='0' ORDER BY dsub DESC LIMIT 1");
$order=$Db1->fetch_array($sql);

if($step >= 3) {
	if(count($_POST) > 0 && false) {
		$vars = serialize(array($_POST, $order));
		$Db1->query("INSERT INTO wizard_posts SET username='$username', posted='".mysql_real_escape_string($vars)."', dsub='".time()."' ");
	}
	include("wizards/final.php");
}
else {

	include("wizards/".$order[ad_type].".php");
}
$includes[title]="Purchase Wizard : $producttitle : Step $step";

?>