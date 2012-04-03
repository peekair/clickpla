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
$includes[title]="Edit Help FAQ";

if($action == "edit") {
	$Db1->query("UPDATE help_faqs SET 
		title='".addslashes($title)."',
		answer='".addslashes($answer)."',
		cat='$cat',
		views='$viewss',
		br='$formatt'
	WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=help&".$url_variables."");
}

$sql=$Db1->query("SELECT * FROM help_faqs WHERE id='$id'");
$faq=$Db1->fetch_array($sql);

$sql=$Db1->query("SELECT * FROM help_cats ORDER BY title");
for($x=0; $cat=$Db1->fetch_array($sql); $x++) {
	$catlist.="<option value=\"$cat[id]\"".iif($faq[cat]==$cat[id],"selected=\"selected\"").">".htmlentities(stripslashes($cat[title]))."";
}

$includes[content]="
<div align=\"Center\">
<form action=\"admin.php?view=admin&ac=edit_help_faq&action=edit&id=$id&".$url_variables."\" method=\"post\">
<table>
	<tr>
		<td>Question</td>
		<td><input type=\"text\" name=\"title\" value=\"".htmlentities(stripslashes($faq[title]))."\" size=\"35\"></td>
	</tr>
	<tr>
		<td>Category: </td>
		<td>
		<select name=\"cat\">
			$catlist
		</select></td>
	</tr>
	<tr>
		<td>Answer</td>
		<td>
			<textarea name=\"answer\" cols=25 rows=5>".htmlentities(stripslashes($faq[answer]))."</textarea><br />
			<input type=\"checkbox\" name=\"formatt\" value=\"1\" ".iif($faq[br]==1," checked=\"checked\"")."> Convert Returns To Line Breaks
		</td>
	</tr>
	<tr>
		<td>Views</td>
		<td><input type=\"text\" name=\"viewss\" value=\"$faq[views]\" size=\"3\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
</form>
</div>

<b>Help</b><br />
	You can use HTML<br />
	You can use PHP variables: <font color=\"blue\">\$variablename</font><br />
	Use If Statements: <font color=\"blue\">{{iif(statement==true,((print me if true)),((print me if false)))}}</font><br />
<b><a href=\"admin.php?view=admin&ac=variables&".$url_variables."\">See list of available variables</a><b>

";

?>
