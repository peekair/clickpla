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
$includes[title]="Moderator Level Manager";
include('admin2/mod_manage_arrays.php');//lots of info, put it in a seperate file
if(isset($_GET['action'])){
$ability=$_POST['ability'];

if($ability!=''){
foreach($ability as $non_menu_check){//pulls each ability into a variable
	if(array_key_exists($non_menu_check,$non_menu_array)){
		foreach($non_menu_array[$non_menu_check] as $non_menu_item){
			$non_menu_list.=','.$non_menu_item;
		}
	}
}

$non_menu_list=ltrim($non_menu_list,',');
$menu_list=join($ability,',');
$edit_user=$_POST['edit_user'];
$ad_manage=$_POST['ad_manage'];
if($edit_user=='none') $edit_user='';
if($ad_manage=='none') $ad_manage='';

if($_POST['id']=='new'){

$Db1->query("INSERT INTO mod_permissions (group_name,menu_ids,non_menu,edit_user,edit_ads) VALUES ('{$_POST['name']}','$menu_list','$non_menu_list','$edit_user','$ad_manage')");
}else{
$Db1->query("UPDATE mod_permissions SET group_name='{$_POST['name']}', menu_ids='$menu_list', non_menu='$non_menu_list', edit_user='$edit_user', edit_ads='$ad_manage' WHERE id='$id'");
}
}
$Db1->sql_close();
header("Location: admin.php?view=admin&ac=mod_manage&saved=true&".$url_variables);
exit;
}

if($id != 'new'){
	$sql=$Db1->query("SELECT * FROM mod_permissions WHERE id='$id'");
	while($db_info=$Db1->fetch_array($sql)){
	$group_name=$db_info['group_name'];
	$edit_ads=$db_info['edit_ads'];
	$edit_user=$db_info['edit_user'];
	$items=explode(',',$db_info['menu_ids']);
	
	}
}else{
$mod_array=array();
$items=array();
}

$includes[content].="
<script>
function CA(isOnload) {
	for (var i=0;i<document.frm.elements.length;i++) {
		var e = document.frm.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox')) {
			if (isOnload != 1) {
				if (e.checked != document.frm.allbox.checked) {
					e.click()
					
				}
				//hL(e, true)
			}
		}
	}
alert(\"Note: User and Ad permissions were not changed\");
}
</script>

<div align='right'><a href='admin.php?view=admin&ac=mod_manage&{$url_variables}'>Back to Moderator Manger</a></div>
Here you can change the permissions of a moderator group.
<form action=\"admin.php?view=admin&ac=mod_manage_level&action=run&{$url_variables}\" method=\"POST\" name=\"frm\"><br \>
Group Name: <input type=\"text\" name=\"name\" size=\"40\" value=\"$group_name\"><br \>
Select All: <input type=\"checkbox\" value=\"1\" name=\"allbox\" onClick=\"CA()\"><br \>
";


foreach($logs_stats_array as $mod_array){
$table_data_logs.="<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
<td>{$mod_array[1]}</td>
<td><div align='center'><input name=\"ability[]\" type=\"checkbox\" value=\"{$mod_array[0]}\"".iif(in_array($mod_array[0],$items)," checked='checked'")."></div></td>

</tr>";
} 

foreach($mod_pages_array as $mod_array){
$table_mod_pages.="<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
<td>{$mod_array[1]}</td>
<td><div align='center'><input name=\"ability[]\" type=\"checkbox\" value=\"{$mod_array[0]}\"".iif(in_array($mod_array[0],$items)," checked='checked'")."></div></td>

</tr>";
} 

$table_edit_view.="<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
<td>User Manager</td>
<td><div align='center'><input name=\"edit_user\" type=\"radio\" value=\"view\"".iif($edit_user=='view'," checked='checked'")."></div></td>
<td><div align='center'><input name=\"edit_user\" type=\"radio\" value=\"edit\"".iif($edit_user=='edit'," checked='checked'")."></div></td>
<td><div align='center'><input name=\"edit_user\" type=\"radio\" value=\"none\"".iif($edit_ads=='' && $id!='new'," checked='checked'")."></div></td>
</tr>
<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
<td>Ad Manager</td>
<td><div align='center'><input name=\"ad_manage\" type=\"radio\" value=\"view\"".iif($edit_ads=='view'," checked='checked'")."></div></td>
<td><div align='center'><input name=\"ad_manage\" type=\"radio\" value=\"edit\"".iif($edit_ads=='edit'," checked='checked'")."></div></td>
<td><div align='center'><input name=\"ad_manage\" type=\"radio\" value=\"none\"".iif($edit_ads=='' && $id!='new'," checked='checked'")."></div></td>
</tr>";
 
 foreach($admin_feat_array as $mod_array){
$table_admin_feat.="<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
<td>{$mod_array[1]}</td>
<td><div align='center'><input name=\"ability[]\" type=\"checkbox\" value=\"{$mod_array[0]}\"".iif(in_array($mod_array[0],$items)," checked='checked'")."></div></td>

</tr>";
} 
 
$includes[content].="Logs and Stats:
<br \>
<table class=\"tableBD1\"><tr class=\"tableHL1\">
<td><b>Permission:</b></td>
<td><b>Can View</b></td>

</tr>
$table_data_logs
</table><br \>
Moderator Functions:
<table class=\"tableBD1\"><tr class=\"tableHL1\">
<td><b>Permission:</b></td>
<td><b>Can View</b></td>
</tr>
$table_mod_pages
</table><br \>
Edit or View Functions:
<table class=\"tableBD1\"><tr class=\"tableHL1\">
<td><b>Permission:</b></td>
<td><b>Can View</b></td>
<td><b>Can Edit</b></td>
<td><b>Cannot View</b></td>
</tr>
$table_edit_view
</table><br \>
Administrator Functions:
<table class=\"tableBD1\"><tr class=\"tableHL1\">
<td><b>Permission:</b></td>
<td><b>Can View</b></td>

</tr>
$table_admin_feat
</table>
<br \><br \>
<input type=\"hidden\" name=\"id\" value=\"$id\">
<input type=\"submit\" value=\"Submit\" name=\"submit\">
</form>
";





?>
