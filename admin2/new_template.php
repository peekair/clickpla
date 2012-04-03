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
$includes[title]="New Template";

$showvalues=0;

if($action == "new") {
	if(($form_template != "") && ($form_title != "")) {
		$Db1->query("INSERT INTO templates SET
			title='".addslashes($form_title)."',
			template='".addslashes($form_template)."',
			login='$form_login',
			premium='$form_premium',
			br='$form_br',
			page='$form_page',
			php='$form_php'
		");
		$error="<b>Your template was added!</b><br /><a href=\"admin.php?view=admin&ac=templates&".$url_variables."\">Click Here</a> to return to the templates manager.";
	}
	else {
		$error="<b>Your template WAS NOT added!</b><br />There was an error adding your template.";
		$showvalues=1;
	}
}


$includes[content]="
$error
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=new_template&action=new&".$url_variables."\" method=\"post\">
	<table>
		<tr>
			<td align=\"right\">Title: ".show_help("This is the title of the template and will be displayed as the page title for page templates.")."</td>
			<td><input type=\"text\" name=\"form_title\"".iif($showvalues == 1," value=\"".stripslashes($form_title)."\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">Members Only: ".show_help("Checking this box will only allow access by members who are logged into their account.")." </td>
			<td><input type=\"checkbox\" value=\"1\" value=\"1\" name=\"form_login\"".iif($showvalues == 1 && ($form_login == 1)," checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">Premium Members Only: ".show_help("Checking this box will only allow access by premium members who are logged into their account.")." </td>
			<td><input type=\"checkbox\" value=\"1\" value=\"1\" name=\"form_premium\"".iif($showvalues == 1 && ($form_premium == 1)," checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">Format Line Breaks: ".show_help("Checking this box will format the line breaks for use in html files. If you do not have this checked, all text will be ran together - unless html is used.")."</td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_br\"".iif($showvalues == 1 && ($form_br == 1)," checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">Page Template: ".show_help("Checking this box will make this template be accessable as a page on the site through a specified URL.")."</td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_page\" ".iif($showvalues == 1 && ($form_page != 1),"","checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td align=\"right\">PHP Code: ".show_help("Is there PHP code in this template? (will be ran before any text is processed)")."</td>
			<td><input type=\"checkbox\" value=\"1\" name=\"form_php\" ".iif($showvalues == 1 && ($form_php == 1),"checked=\"checked\"")."></td>
		</tr>
		<tr>
			<td colspan=2>
			<textarea name=\"form_template\" cols=50 rows=10>".iif($showvalues == 1,stripslashes("$form_template"))."</textarea>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Create Template\"></td>
		</tr>
	</table>
</form>
</div>

";
?>
