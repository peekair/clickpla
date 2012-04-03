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
if($mode == "addPerm") {
	$sql=$Db1->query("SELECT * FROM member_groups_defined WHERE id='$permId'");
	$perm = $Db1->fetch_array($sql);
	$Db1->query("SELECT * FROM member_groups_perms WHERE `group`='$id' and perm='$perm[perm]'");
	if($Db1->num_rows() == 0) {
		$Db1->query("INSERT INTO member_groups_perms SET 
			`group`='$id',
			perm='$perm[perm]',
			value='1'
		");
	}
}

if($mode == "save") {
	$Db1->query("INSERT INTO member_groups SET title='$title'");
}


if($mode == "delete") {
	$Db1->query("DELETE FROM member_groups WHERE id='$id'");
	$Db1->query("DELETE FROM member_groups_perms WHERE `group`='$id'");
	$Db1->query("UPDATE user SET `group`='' WHERE `group`='$id'");
}


$sql=$Db1->query("SELECT member_groups.*, COUNT(userid) as total FROM member_groups 
	LEFT JOIN user ON
	user.group=member_groups.id
	GROUP BY member_groups.id
	");
if($Db1->num_rows() > 0) {
	while($temp = $Db1->fetch_array($sql)) {
		$permlist="";
		$sql2=$Db1->query("SELECT member_groups_perms.*, member_groups_defined.desc 
			FROM member_groups_perms LEFT JOIN member_groups_defined 
			ON 
				member_groups_perms.perm = member_groups_defined.perm
			WHERE
				member_groups_perms.`group`='$temp[id]'
				
				");
			
		while($perms=$Db1->fetch_array($sql2)) {
			$permlist.="".$perms['desc']."<br />";
			// : $perms[value]
		}
		
		
		
		$list.="
		<tr>
			<td style=\"width: 16px; padding: 0px;\"><a href=\"\" onclick=\"".iif($temp[total]>0,"if(confirm('Are you sure? There are $temp[total] users in this group!')) ")."deleteGroup('$temp[id]'); return false;\"><img src=\"admin2/includes/icons/block1.gif\" width=16 height=16 border=0></a></td>
			<td>$temp[title]</td>
			<td>".iif($permlist=="","&nbsp;",$permlist)."</td>
			<td style=\"width: 16px; padding: 0px;\"><a href=\"\" onclick=\"loadNewPermPop('$temp[id]'); return false;\"><img src=\"admin2/includes/icons/add.gif\" width=16 height=16 border=0></a></td>
			<td>$temp[total] <a href=\"admin.php?ac=members&search=1&search_str=".$temp[id]."&search_by=group&step=2&".$url_variables."\"><img src=\"admin2/includes/icons/find.gif\" width=13 height=13 border=0></a></td>
		</tr>
		";
		
	}

echo "
	<table class=\"tableStyle2\"  style=\"width: 600px\">
		<tr class=\"tableHead\">
			<td colspan=2><b>Group</b></td>
			<td colspan=2><b>Permissions</b></td>
			<td><b>Users</b></td>
		</td>
		$list
	</table>
";
} else {
	echo "There are no groups!";
}

?>

<script>
tableLoaded();
</script>