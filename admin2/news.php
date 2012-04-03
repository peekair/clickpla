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
$includes[title]="Add News";
//**S**//
if($action == "add") {
	$sql=$Db1->query("INSERT INTO news SET title='".addslashes($title)."', dsub='".time()."', news='".addslashes($news)."'");
}


$sql=$Db1->query("SELECT * FROM news ORDER BY id");

	
		$sql2=$Db1->query("SELECT * FROM news");
		$faqs="";
	while($faq=$Db1->fetch_array($sql2)) {
		$faqs.="<option value=\"$faq[id]\">".htmlentities(stripslashes($faq[title]))."";
	}
	
	$thelist.="
	<tr class=\"tableHL1\">
		<td><b><big>News</big></b></td>
					
		
	</tr>
	<tr class=\"tableHL2\"> 
		<td colspan=2 align=\"center\">
		
		<select name=\"faqlist$x\">
			<option value=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			$faqs
		</select>

		<input type=\"button\" value=\"Edit\" onclick=\"if(document.faqform.faqlist$x.value != '') {location.href='admin.php?view=admin&ac=edit_news&id='+document.faqform.faqlist$x.value+'&".$url_variables."'} else {alert('Select News to edit!')}\">
		<input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this?')) location.href='admin.php?view=admin&ac=delete_news&id='+document.faqform.faqlist$x.value+'&".$url_variables."'\">

		</td>
	</tr>
	
	";
$includes[content]="
<form name=\"faqform\">
<table width=\"100%\">
	$thelist
</table>
</form>
<form method=\"post\" action=\"admin.php?view=admin&ac=news&action=add&".$url_variables."\">
<table>
	<tr>
		<td>Title</td>
		<td><input type=\"text\" name=\"title\"></td>
	</tr>
	<tr>
		<td colspan=2>News:<br /><textarea name=\"news\" cols=25 rows=5></textarea></td>
	</tr>
	<tr>
		<td align=\"center\" colspan=2><input type=\"submit\" value=\"Add News\"></td>
	</tr>
</table>
</form>
";
//**E**//
?>
