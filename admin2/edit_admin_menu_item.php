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
$includes[title]="Edit Admin Menu Item";


if($action == "save") {
	$Db1->query("UPDATE admin_menu SET
		title='".addslashes($title)."',
		type='$type',
		icon='".addslashes($icon)."',
		url='".addslashes($url)."',
		`order`='$order',
		append='$append',
		module='$mmodule',
		parent='$parent'
		WHERE id='$id'
	");
	$msg="Saved!";
}

$sql=$Db1->query("SELECT * FROM admin_menu WHERE id='$id'");
$menu=$Db1->fetch_array($sql);



$sql=$Db1->query("SELECT * FROM admin_menu WHERE type='0' ORDER BY `order`");
while($temp1 = $Db1->fetch_array($sql)) {
	$plist.="<option value=\"$temp1[id]\"".iif($temp1[id] == $menu['parent']," selected=selected").">$temp1[title]";
	$sql2=$Db1->query("SELECT * FROM admin_menu WHERE type='1' and parent='$temp1[id]' ORDER BY `order`");
	while($temp2 = $Db1->fetch_array($sql2)) {
		$plist.="<option value=\"$temp2[id]\"".iif($temp2[id] == $menu['parent']," selected=selected").">$temp1[title] -> $temp2[title]";
	}
	$plist.="<option value=\"\">";
}

$sql=$Db1->query("SELECT * FROM admin_modules WHERE active='1' ORDER BY type");
while($temp=$Db1->fetch_array($sql)) {
	$moduleList.="<option value=\"$temp[id]\"".iif($temp[id] == $menu['module']," selected=selected").">$temp[type]";
}

$includes[content]="
<div style=\"float: right;\"><a href=\"admin.php?ac=edit_admin_menu&".$url_variables."\">Back To Menu Editor</a></div>

$msg
<form action=\"admin.php?ac=edit_admin_menu_item&id=$id&action=save&".$url_variables."\" method=\"post\">

<table class=\"tableStyle2\">
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"".$menu[title]."\" style=\"width: 220px\"></td>
	</tr>
	<tr>
		<td>Type</td>
		<td>
		<select name=\"type\">
			<option value=\"0\" ".iif($menu[type]==0," selected=selected").">Top Category
			<option value=\"1\" ".iif($menu[type]==1," selected=selected").">Sub Category
		</select>
		</td>
	</tr>
".iif($menu[type]==0,"
	<tr>
		<td>Icon: </td>
		<td><input type=\"text\" name=\"icon\" value=\"".$menu[icon]."\">".iif($menu[icon]!="","<img src=\"admin2/includes/icons/".$menu[icon]."\" align=\"absmiddle\">")."</td>
	</tr>
")."
	<tr>
		<td>Url: </td>
		<td><input type=\"text\" name=\"url\" value=\"".$menu['url']."\" style=\"width: 220px\"></td>
	</tr>
	<tr>
		<td>Order: </td>
		<td><input type=\"text\" name=\"order\" value=\"".$menu['order']."\" size=3></td>
	</tr>
	<tr>
		<td>Append: </td>
		<td><input type=\"checkbox\" name=\"append\" value=\"1\" ".iif($menu[append]==1,"checked=checked")."></td>
	</tr>
	<tr>
		<td>Module: </td>
		<td><select name=\"mmodule\"><option value=\"\">$moduleList</select></td>
	</tr>
	<tr>
		<td>Parent: </td>
		<td><select name=\"parent\"><option value=\"\" />$plist</select></td>
	</tr>
	<tr class=\"tableHead\">
		<td colspan=2><input type=\"submit\" value=\"Save\"</td>
	</tr>
</table>
</form>

";
?>