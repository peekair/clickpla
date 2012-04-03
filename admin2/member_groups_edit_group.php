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
$includes[title]="Edit Member Groups";

$sql2=$Db1->query("SELECT * FROM member_groups_defined");

while($perms=$Db1->fetch_array($sql2)) {
	$permlist.="
		<tr>
			<td>".$perms['desc']."</td>
			<td>".$perms['perm']."</td>
			<td style=\"width: 16px; text-align: center;\"><a href=\"\" onclick=\"addPerm('".$perms['id']."'); return false;\"><img src=\"admin2/includes/icons/add.gif\" width=16 height=16 border=0></a></td>
		</tr>";
}



$includes[content]="
<div style=\"width: 600px\">

	<div style=\"text-align: right;\">
		<a href=\"\" onclick=\"openAdminPopup('memberGroupsNew','Create New Group'); return false;\" class=\"linkStyle2\"><img src=\"admin2/includes/icons/add.gif\" border=0 align=\"absmiddle\" title=\"New Group\"></a>
	</div>

<div id=\"memberGroupsTable\"></div>




<div class=\"hidden\">
	<div id=\"memberGroupsNew\" style=\"padding: 10px; height: 80px\">
		<form onsubmit=\"addGroup(); return false\" style=\"padding: 0px; margin: 0px;\">
		<table class=\"tableStyle1\" align=\"right\">
			<tr>
				<td><b>Group Title</b></td>
				<td><input type=\"text\" style=\"width: 140px\" id=\"newGroupName\"></td>
			</tr>
			<tr>
				<td colspan=2><input type=\"submit\" value=\"Add Group\" id=\"newButton\"></td>
			</tr>
		</table>
		</form>
	</div>
	
	
	<div id=\"newGroupPermPopup\" style=\"padding: 10px;\">
		<table class=\"tableStyle2\" style=\" width: 400px;\">
			<tr class=\"tableHead\">
				<td><b>Title</b></td>
				<td><b>ID</b></td>
				<td style=\"width: 16px\"></td>
			</tr>
			$permlist
		</table>
	</div>
</div>



<script>
function addGroup() {
	var title = document.getElementById('newGroupName').value;
	if(title != '') {
		closeAdminPopup()
		loadAjaxPage('memberGroupsTable', 'memberGroups', 'groupListing', 'mode=save&title='+title+'&');
	}
	else alert('You must enter a group title!');
}

function tableLoaded() {
	document.getElementById('newGroupName').value='';
}

function deleteGroup(id) {
	loadAjaxPage('memberGroupsTable', 'memberGroups', 'groupListing', 'mode=delete&id='+id+'&');
}

var currentPermPopId;
function loadNewPermPop(id) {
	currentPermPopId=id;
	openAdminPopup('newGroupPermPopup','New Permissions');
}

function addPerm(id) {
	loadAjaxPage('memberGroupsTable', 'memberGroups', 'groupListing', 'mode=addPerm&permId='+id+'&id='+currentPermPopId+'&');
}

loadAjaxPage('memberGroupsTable', 'memberGroups', 'groupListing', '');
</script>


</div>
";


?>