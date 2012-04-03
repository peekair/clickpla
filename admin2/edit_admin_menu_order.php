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
$includes[title]="Edit Admin Menu Order";

if($action == "save") {
	foreach($itemOrder as $k => $v) {
//		echo "$k - $v <br />";
		$Db1->query("UPDATE admin_menu SET `order`='$v' WHERE id='$k'");
	}
	$msg="Saved!";
}


$sql=$Db1->query("SELECT * FROM admin_menu WHERE ".iif($parent!=0,"parent='$parent'","type='0'")." ORDER BY `order`");
while($temp = $Db1->fetch_array($sql)) {
	$list.="
	<tr>
		<td>$temp[title]</td>
		<td><input type=\"text\" name=\"itemOrder[".$temp[id]."]\" size=3 value=\"$temp[order]\"></td>
	</tr>";
}

$includes[content]="
<div style=\"float: right;\"><a href=\"admin.php?ac=edit_admin_menu&".$url_variables."\">Back To Menu Editor</a></div>

$msg
<form action=\"admin.php?ac=edit_admin_menu_order&parent=$parent&action=save&".$url_variables."\" method=\"post\">
<table class=\"tableStyle2\">
	<tr class=\"tableHead\">
		<td><b>Menu Item</b></td>
		<td><b>Order</b></td>
	</tr>
	$list
	<tr class=\"tableHead\">
		<td colspan=2><input type=\"submit\" value=\"Save Order\"</td>
	</tr>
</table>
";


?>