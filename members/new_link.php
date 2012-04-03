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
$includes[title]="Add A New Link";
//**S**//
if($action == "add") {
	$title=stripslashes(str_replace("\"","",$title));
	$title=stripslashes(str_replace("'","",$title));
	$target=stripslashes(str_replace("\"","",$target));
	$target=stripslashes(str_replace("'","",$target));
	if((!isset($title)) || ($title=="")) {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://")) {
		$error_msg="You must enter a valid target URL!";
	}
	else {
		$sql=$Db1->query("INSERT INTO ads SET title='$title', dsub='".time()."', username='$username', target='$target'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=my_ads&".$url_variables."");
	}
}

if($target=="") {
	$target="http://";
}
//**E**//
$includes[content]="
".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if your unable to use our member features!</div>")."
".iif($thismemberinfo[confirm] ==1,"
".iif($error_msg,"<script>alert('$error_msg');</script>")."
<div align=\"center\">
<form action=\"index.php?view=account&ac=new_link&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<table>
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"$title\"></td>
	</tr>
	<tr>
		<td>Target Url: </td>
		<td><input type=\"text\" name=\"target\" value=\"$target\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Link\"></td>
	</tr>
</table>
</div>")."
";
?>
