<?

$view="admin";
include("./header.php");
include("./includes/modules.php");
$filename = '/install';
$filename2 = '/install/';

$filename = 'install';
$filename2 = 'install/';

if(file_exists($filename) && is_dir($filename)) {
    echo "Please delete the Install directory to continue";
    exit;
    }

if ($action == pass){
$MRVPassword = $_POST['spass'];
$date_of_expiry = time() + 3600 ;
setcookie( "MRVPassword", "$MRVPassword", $date_of_expiry );

;

}

if(!$permission == 7 && false) {
	$Db1->sql_close();
	header("Location: index.php?view=login");
	exit;
}

//include("./templates/$settings[template]/layout.php");

function checkIfModule($menu) {
	global $Db1;
	if($menu[module] != 0) {
		$sql=$Db1->query("SELECT * FROM admin_modules WHERE id='$menu[module]'");
		$temp=$Db1->fetch_array($sql);
		if($temp[active] == 1) return true;
		else return false;
	}
	else return true;
}


function buildMenu() {
	$dci=0;
	global $Db1, $url_variables;
	$sql=$Db1->query("SELECT * FROM admin_menu WHERE type='0' ORDER BY `order`");
	$list.="";
	while($temp1 = $Db1->fetch_array($sql)) {
		if(checkIfModule($temp1)) {
			$dci++;
			$list.="<div class=\"menuMainItem\"><img src=\"admin2/includes/icons/".$temp1[icon]."\" align=\"absmiddle\">
				<a 
					href=\"".iif($temp1[url]!="",$temp1[url].iif($temp1[append] ==1,"&".$url_variables)  )."\" 
					".iif($temp1[url]=="","onclick=\"return toggleSub('$dci')\"")."
					>$temp1[title]</a></div>";
			
			$sql2=$Db1->query("SELECT * FROM admin_menu WHERE parent='$temp1[id]' ORDER BY `order`");
			if($Db1->num_rows() > 0) {
				$list.="<div id=\"dropCont".$dci."\" class=\"dropContDiv\">";
				while($temp2 = $Db1->fetch_array($sql2)) {
					if(checkIfModule($temp2)) {
						$dci++;
						$list.="<div class=\"menuMainSubHead\">
							<a 
								href=\"".iif($temp2[url]!="",$temp2[url].iif($temp2[append] ==1,"&".$url_variables))."\" 
								".iif($temp2[url]=="","onclick=\"return toggleSub('$dci')\"")."
								>$temp2[title]</a></div>";
								
						$sql3=$Db1->query("SELECT * FROM admin_menu WHERE parent='$temp2[id]' ORDER BY `order`");
						if($Db1->num_rows() > 0) {
							$list.="<div id=\"dropCont".$dci."\" class=\"dropContDiv\">";
							while($temp3 = $Db1->fetch_array($sql3)) {
								if(checkIfModule($temp3)) {
									$list.="<div class=\"menuMainSub\"><img src=\"admin2/includes/media/menuSubItem.gif\">
										<a href=\"".iif($temp3[url]!="",$temp3[url].iif($temp3[append] ==1,"&".$url_variables))."\" >$temp3[title]</a></div>";
								}
							}
							$list.="</div>";
						}			
					}
				}
				$list.="</div>";
			}
		}
	}
	//$list.="</div>";
	return $list;
}




$Db1->sql_close();
//exit;
?>
<?php
function def_version() {
define('VERSION', '5.7.3');
	$version = VERSION; 
	echo "<center><font color=green><b>You currently have MRV ";
	echo "$version";
	echo " of the script</b></font></center>";
	echo "<br />";
	
define('REMOTE_VERSION', 'http://www.maderitehosting.com/mrvversion/mrvver.txt');
define('VERSION', $version);
$script = file_get_contents(REMOTE_VERSION);
$version1 = VERSION;
if($version1 == $script) {
    echo "<div> 
<center><font color=green><b>You have the latest version!</b></font></center>
</div>";
} else {
    echo "<div> 
<center><font color=red><b>There is an update available (MRV ".$script.") !</b></font></center>
<p align=center> <font color=red>Please contact your <a href=http://www.maderitehosting.com/distributors.htm target=_blank>Authorized Reseller</a> for latest version</font>
</div>";
}
}
?>
<head>
<title>Aurora MRV 5.7.3 Admin Panel</title>

<link rel="stylesheet" type="text/css" href="admin2/includes/style.css" />
<link rel="stylesheet" type="text/css" href="includes/ajax/ajaxtabs.css" />
<link rel="stylesheet" type="text/css" href="includes/ajax/components.css" />

<script type="text/javascript" src="includes/ajax/jquery.js"></script>
<script type="text/javascript" src="admin2/includes/admin.js"></script>

<script type="text/javascript" src="functions.js"></script>

<script type="text/javascript" src="includes/ajax/ajaxtabs.js"></script>
<script type="text/javascript" src="admin2/includes/js/ptsuManager.js"></script>
<script type="text/javascript" src="admin2/includes/js/memberManager.js"></script>
<script type="text/javascript" src="includes/ajax/ad_manager.js"></script>
<script type="text/javascript" src="includes/ajax/prototype.js"></script>

<script>
url_variables = '<? echo iif($sid, "sid=".$sid."&").iif($sid2, "sid2=".$sid2."&").iif($siduid, "siduid=".$siduid.""); ?>';
//ajax_resource='ptsu';
</script>


<body>

<script>


</script>

<? $dci=0; ?>
<table width="100%" height="100%" cellpadding=0 cellspacing=0>
	<tr>
		<td height="50" colspan=2>
			<div id="logoHeader">
				<div id="adminHeading"> <a href="changelog.php?<?=$url_variables?>" style="color: black; font-size: 15px; font-weight: bold;" target="_blank">MRV Changelog</b></font></a> | <a href="index.php?<?=$url_variables?>" style="color: black; font-size: 15px; font-weight: bold;" target="_blank">Back to <?=ucwords($settings[domain_name]); ?></a> | </a>
<img src="admin2/includes/icons/home.gif"><? echo iif($permission == 7,"<a href=\"admin.php?".$url_variables."\" style=\"color: black; font-size: 15px; font-weight: bold;\"><small>Admin Panel</small></a>"); ?></div>
				<div id="agptHeading"> MadeRite MRV 5.7.3 Admin Panel</div>
			</div>
		</td>
	</tr>
	<td width="170" valign="top">
		<div id="menuMainCont">
			<div class="mainMenu">
				<? echo buildMenu(); ?>
			</div>
		</div>
	</td>
	<td valign="top">
			<div id="contentMainHeaderCont">
				<div style="float: left;"><?=$includes[title]; ?></div>
				<div style="float: left; padding: 7 0 0 10px; display: none;" id="adminLoading"><img src="images/loading3.gif" align="absmiddle"><img src="images/loadingLabel.gif" align="absmiddle"></div>
			</div>
		<div id="contentMainCont"><?php def_version() ?>
			<?=$includes[content]; ?>
		</div>
	</td>
</table>

<script>
openHoldMenus();
setAdminLoading(0);
</script>


<div id="domStorage"></div>

	<div class="adminPopup" id="adminPopupCont">
		<table width="321" height="10" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="100%" height="32">
					<table width="100%" height="32" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><img src="images/popup_01.gif" width="13" height="32" alt=""></td>
							<td background="images/popup_02.gif" width="100%" height="32">
							<div id="adminPopupTitle"></div>
							</td>
							<td><a href="" onclick="closeAdminPopup(); return false;"><img src="images/popup_03.gif" width="31" height="32" alt="" border=0></a></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="100%" height="100%">
					<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td background="images/popup_04.gif" width="6" height="100%"><img src="images/popup_04.gif" width="6" height="1" alt=""></td>
							<td style="background-color: white;" width="100%" height="100%">
								<div id="adminPopupContent"></div>
							</td>
							<td background="images/popup_06.gif" width="6" height="100%"><img src="images/popup_06.gif" width="6" height="1" alt=""></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td width="100%" height="5">
					<table width="100%" height="5" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><img src="images/popup_07.gif" width="6" height="5" alt=""></td>
							<td background="images/popup_08.gif" width="100%" height="5"><img src="images/popup_08.gif" width="1" height="5" alt=""></td>
							<td><img src="images/popup_09.gif" width="6" height="5" alt=""></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>


</body>

</html>