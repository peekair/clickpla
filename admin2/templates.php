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
$includes[title]="Manage Templates";

$sql=$Db1->query("SELECT * FROM templates ORDER BY title");
if($Db1->num_rows() != 0) {
	while($temp=$Db1->fetch_array($sql)) {
		$list.="
		<tr>
			<td>$temp[id] &nbsp;&nbsp;&nbsp; $temp[title] &nbsp;&nbsp;&nbsp;<small>
				<a href=\"admin.php?view=admin&ac=edit_template&id=$temp[id]&".$url_variables."\">Edit</a>&nbsp;&nbsp;&nbsp;
				<a href=\"admin.php?view=admin&ac=edit_template&action=delete&id=$temp[id]&".$url_variables."\" onclick=\"return confirm('Are you sure you want to delete this?')\">Delete</a></small>&nbsp;&nbsp;&nbsp;
			</tD>
			<td align=\"right\">".iif($temp[page]==1,"Hits: $temp[hits] &nbsp;&nbsp;&nbsp;Today: $temp[hits_today]")."</td>
		</tr>".iif($temp[page]==1,"
		<tr>
			<td colspan=2><a href=\"$settings[base_url]/index.php?view=page&type=2&id=$temp[id]\" target=\"_blank\">$settings[base_url]/admin.php?view=page&type=2&id=$temp[id]</a></tD>
		</tr>")."
		<tr>
			<td height=1 bgcolor=\"black\" colspan=2></td>
		</tr>
		";
	}
}
else {
	$list="
	<tr>
		<td>There are no templates in the system!</td
	</tr>
	";
}

$includes[content]="
<div align=\"right\"><b><a href=\"admin.php?view=admin&ac=new_template&".$url_variables."\">Add New Template</a></b></div>
<table width=\"100%\" cellpadding=0 cellspacing=0>
		<tr>
			<td height=1 bgcolor=\"black\" colspan=2></td>
		</tr>
	$list
</table>

<br />

<small>
Templates allow you to easily create and edit pages & text for your website. When you create a \"page\" template, you can access it through an assigned URL that will show your template on its own page of the site.
</small>

";

?>
