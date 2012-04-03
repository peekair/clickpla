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

$includes[title]="Moderator Manager";

if($_GET['saved']==true){
	$includes[content].="<font color='red'>Your changes have been saved.</font><br \><br \>";
}
if($_GET['action']=="delete"){
	$Db1->query("DELETE FROM mod_permissions WHERE id={$_GET['id']}");
	header("Location: admin.php?view=admin&ac=mod_manage&saved=true&{$url_variables}");
}

$sql=$Db1->query("SELECT * FROM mod_permissions");
	if($Db1->num_rows()!=0){
		while($levels=$Db1->fetch_array($sql)){
			if($levels['menu_ids']!=''){
				$pages=substr_count($levels['menu_ids'],',')+1;
			}
			if($levels['edit_user']==''){
				$users='None';}else{
				$users=ucfirst($levels['edit_user']).'able';}
			if($levels['edit_ads']==''){
				$ads='None';
			} 
			else {
				$ads=ucfirst($levels['edit_ads']).'able';
			}
			$sql2=$Db1->query("SELECT COUNT(userid) AS total FROM user WHERE permission='6' AND mod_permission='$levels[id]'");
			$modcount=$Db1->fetch_array($sql2);
			
$content_temp.="<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
<td style=\"padding: 0 5 0 5px;\"><a href='admin.php?view=admin&ac=mod_manage_level&id={$levels['id']}&{$url_variables}'>{$levels['group_name']}*</a></td>
<td style=\"padding: 0 5 0 5px;\">{$pages}</td>
<td style=\"padding: 0 5 0 5px;\">{$modcount[total]}</td>
<td style=\"padding: 0 5 0 5px;\">{$users}</td>
<td style=\"padding: 0 5 0 5px;\">{$ads}</td>
<td style=\"padding: 0 5 0 5px;\"><a href='admin.php?view=admin&ac=mod_manage&action=delete&id={$levels['id']}&{$url_variables}'>Delete</a></td>

</tr>";
		}//end while fetch_array

$includes[content].="
<div align=\"center\">
<table class=\"tableBD1\" cellpadding=0 cellspacing=1><tr class=\"tableHL1\">
<td style=\"padding: 0 5 0 5px;\"><b>Group Name:</b></td>
<td style=\"padding: 0 5 0 5px;\"><b>Abilities</b></td>
<td style=\"padding: 0 5 0 5px;\"><b>Mods</b></td>
<td style=\"padding: 0 5 0 5px;\"><b>Users</b></td>
<td style=\"padding: 0 5 0 5px;\"><b>Ads</b></td>
<td style=\"padding: 0 5 0 5px;\"><b>Delete?</b></td>
</tr>
$content_temp
</table>
</div>
<br /><br />
";
}
else{
	$includes[content].="There are no moderator levels currently set.<br \>";
}//end else

$includes[content].="<a href=\"admin.php?view=admin&ac=mod_manage_level&id=new&{$url_variables}\">Add a new Moderator Level</a>";



?>

