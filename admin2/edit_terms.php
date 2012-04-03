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
$includes[title]="Edit Terms";

if($action == "edit") {
	$Db1->query("UPDATE terms SET 
		title='".addslashes($title)."',
		terms='".addslashes($terms)."',
		imglink='".$settings[base_url]."/images/icons/termsicon.png',
        dsub='".time()."'
	WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=terms&".$url_variables."");
}

$sql=$Db1->query("SELECT * FROM terms WHERE id='$id'");
$faq=$Db1->fetch_array($sql);

$includes[content]="
<div align=\"Center\">
<form action=\"admin.php?view=admin&ac=edit_terms&action=edit&id=$id&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td>Title Of Terms</td>
		<td><input type=\"text\" name=\"title\" value=\"".htmlentities(stripslashes($faq[title]))."\" size=\"35\"></td>
	</tr>
	
	<tr>
		<td>Terms Text:</td>
		<td>
			<textarea name=\"terms\" cols=25 rows=5>".htmlentities(stripslashes($faq[terms]))."</textarea><br />
			<br>
		</td>
	</tr>
	
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
</form>
</div>


";

?>