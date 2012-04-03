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
$includes[title]="Edit Admin Menu";

if($action == "new1") {
	$Db1->query("INSERT INTO admin_menu SET
		title='$title',
		icon='$icon',
		url='$url',
		type='0',
		append='$append'
	");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_admin_menu&".$url_variables."");
	exit;
}


if($action == "new2") {
	$Db1->query("INSERT INTO admin_menu SET
		title='$title',
		icon='$icon',
		url='$url',
		type='1',
		parent='$parent',
		append='$append',
		module='$mmodule'
	");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_admin_menu&parent=$parent&".$url_variables."");
	exit;
}


if($action == "new3") {
	$Db1->query("INSERT INTO admin_menu SET
		title='$title',
		icon='$icon',
		url='$url',
		type='1',
		parent='$parent',
		append='$append',
		module='$mmodule'
	");
	$Db1->sql_close();
	header("Location: admin.php?ac=edit_admin_menu&parent=$parent&".$url_variables."");
	exit;
}


$sql=$Db1->query("SELECT * FROM admin_menu WHERE type='0' ORDER BY `order`");
$list.="
<menu style=\"width: 700px; background-color: #e8e8e8; margin: 3px; border: 2px dashed white;\">
<div style=\"float: right\"><a href=\"admin.php?ac=edit_admin_menu_order&parent=0&".$url_variables."\" title=\"Edit order for this group\"><img src=\"admin2/includes/icons/sitemap.gif\" border=0></a></div>
";
while($temp1 = $Db1->fetch_array($sql)) {
	$plist1.="<option value=\"$temp1[id]\"".iif($temp1[id] == $parent," selected=selected").">$temp1[title]";
	$list.="<li style=\"border-top: 1px dashed white;\"><b>
		<a href=\"admin.php?ac=edit_admin_menu_item&id=$temp1[id]&".$url_variables."\" style=\"color: black\">$temp1[title]</a></b>";
	$sql2=$Db1->query("SELECT * FROM admin_menu WHERE parent='$temp1[id]' ORDER BY `order`");
	if($Db1->num_rows() > 0) {
		$list.="
			<menu style=\"background-color: #d8d8d8; margin-bottom: 5px; padding-bottom: 10px; width: 500px\">
			<div style=\"float: right\"><a href=\"admin.php?ac=edit_admin_menu_order&parent=$temp1[id]&".$url_variables."\" title=\"Edit order for this group\"><img src=\"admin2/includes/icons/sitemap.gif\" border=0></a></div>
			";
		while($temp2 = $Db1->fetch_array($sql2)) {
			$plist2.="<option value=\"$temp2[id]\"".iif($temp2[id] == $parent," selected=selected").">$temp1[title] -> $temp2[title]";
			$list.="<li><b><a href=\"admin.php?ac=edit_admin_menu_item&id=$temp2[id]&".$url_variables."\" style=\"color: black\">$temp2[title]</a></b>";
			$sql3=$Db1->query("SELECT * FROM admin_menu WHERE parent='$temp2[id]' ORDER BY `order`");
			if($Db1->num_rows() > 0) {
				$list.="
					<menu style=\"background-color: #f8f8f8; width: 300px\">
					<div style=\"float: right\"><a href=\"admin.php?ac=edit_admin_menu_order&parent=$temp2[id]&".$url_variables."\" title=\"Edit order for this group\"><img src=\"admin2/includes/icons/sitemap.gif\" border=0></a></div>
				";
				while($temp3 = $Db1->fetch_array($sql3)) {
					$list.="<li><b><a href=\"admin.php?ac=edit_admin_menu_item&id=$temp3[id]&".$url_variables."\" style=\"color: black\">$temp3[title]</a></b>";
				}
				$list.="</menu>";
			}			
		}
		$list.="</menu>";
	}
}
$list.="</menu>";


$sql=$Db1->query("SELECT * FROM admin_modules WHERE active='1' ORDER BY type");
while($temp=$Db1->fetch_array($sql)) {
	$moduleList.="<option value=\"$temp[id]\">$temp[type]";
}

$includes[content]="

<hr>
<table cellpadding=20 width=100%>
	<tr>
		<td>
			<form action=\"admin.php?ac=edit_admin_menu&action=new1&".$url_variables."\" method=\"post\">
			<b>Create Master Category</b><br />
			Title: <input type=\"text\" name=\"title\"><br />
			Icon:  <input type=\"text\" name=\"icon\"><br />
			Url:  <input type=\"text\" name=\"url\"><br />
			 <input type=\"checkbox\" value=\"1\" name=\"append\"><small>Append URL Variables?</small>
			<br />
			 <input type=\"submit\" value=\"Create\">
			</form>
		</td>
		<td>
			<form action=\"admin.php?ac=edit_admin_menu&action=new2&".$url_variables."\" method=\"post\">
			<b>Create Sub Category</b><br />
			Parent: <select name=\"parent\">$plist1</select><br />
			Title: <input type=\"text\" name=\"title\"><br />
			Url:  <input type=\"text\" name=\"url\"><input type=\"checkbox\" value=\"1\" name=\"append\">
			<br />
			Module: <select name=\"mmodule\">
				<option value=\"\">
				$moduleList
			</select>
			<br />
			<input type=\"submit\" value=\"Create\">
			</form>
		</td>
		<td>
			<form action=\"admin.php?ac=edit_admin_menu&action=new3&".$url_variables."\" method=\"post\">
			<b>Create Sub-Child Category</b><br />
			Parent: <select name=\"parent\">$plist2</select><br />
			Title: <input type=\"text\" name=\"title\"><br />
			Url:  <input type=\"text\" name=\"url\" size=60 value=\"admin.php?ac=\"> <input type=\"checkbox\" value=\"1\" name=\"append\" checked>&</small>
			<br />
			Module: <select name=\"mmodule\">
				<option value=\"\">
				$moduleList
			</select>
			<br />
			<input type=\"submit\" value=\"Create\">
			</form>
		</td>
	</tr>
</table>

$list


";

?>