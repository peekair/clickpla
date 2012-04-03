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
$includes[title]="Edit Template";

$showvalues=1;

if($action == "delete") {
	$Db1->query("DELETE FROM templates WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=templates&".$url_variables."");
}

if($action == "save") {
	if(($form_template != "") && ($form_title != "")) {
		$Db1->query("UPDATE templates SET
				title='".addslashes($form_title)."',
				template='".addslashes($form_template)."',
				login='$form_login',
				br='$form_br',
				page='$form_page',
				php='$form_php'
			WHERE id='$id'
		");
		$error="<b>Your template was saved!</b><br /><a href=\"admin.php?view=admin&ac=templates&".$url_variables."\">Click Here</a> to return to the templates manager.";
	}
	else {
		$error="<b>Your template WAS NOT saved!</b><br />There was an error adding your template.";
		$showvalues=1;
	}
}

$sql=$Db1->query("SELECT * FROM templates WHERE id='$id'");
$temp=$Db1->fetch_array($sql);


$includes[content]="
$error
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=edit_template&action=save&id=$id&".$url_variables."\" method=\"post\">
	<table>
		<tr>
			<td align=\"right\">Title: <a href=\"#\" onclick=\"return !showPopup('pbalance', event,'This is the title of the template and will be displayed as the page title for page templates.');\">?</a></td>
			<td><input type=\"text\" name=\"form_title\" value=\"".stripslashes($temp[title])."\"></td>
		</tr>
		<tr>
			<td align=\"right\">Members Only: <a href=\"#\" onclick=\"return !showPopup('pbalance', event,'Checking this box will only allow access by members who are logged into their account.');\">?</a> </td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_login\"".iif(($temp[login] == 1)," checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">Format Line Breaks: <a href=\"#\" onclick=\"return !showPopup('pbalance', event,'Checking this box will format the line breaks for use in html files. If you do not have this checked, all text will be ran together - unless html is used.');\">?</a></td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_br\"".iif(($temp[br] == 1)," checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">Page Template: <a href=\"#\" onclick=\"return !showPopup('pbalance', event,'Checking this box will make this template be accessable as a page on the site through a specified URL.');\">?</a></td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_page\" ".iif(($temp[page] != 1),"","checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">PHP Code: <a href=\"#\" onclick=\"return !showPopup('pbalance', event,'Is there PHP code in this template? (will be ran before any text is processed)');\">?</a></td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_php\" ".iif(($temp[php] == 1),"checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td colspan=2>
			<textarea name=\"form_template\" cols=50 rows=10>".stripslashes("$temp[template]")."</textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=\"center\">
				<input type=\"submit\" value=\"Save Template\">
				<input type=\"button\" value=\"Delete Template\" onclick=\"if(confirm('Are you sure you want to delete this?') == true) location.href='admin.php?view=admin&ac=edit_template&action=delete&id=$id&".$url_variables."'\">
			</td>
		</tr>
	</table>
</form>

".iif($temp[page]==1,"
This template can be accessed through the following URL: <br />
<a href=\"$settings[base_url]/admin.php?view=page&type=2&id=$temp[id]\" target=\"_blank\">$settings[base_url]/admin.php?view=page&type=2&id=$temp[id]</a>
")."

</div>

";
?>
