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
$includes[title]="Add A New Featured Ad";

if($action == "add") {
	$title=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$title))));
	$target=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$target))));
	$fad=stripslashes(str_replace("'","",stripslashes(str_replace("\"","",$fad))));

	if((!isset($title)) || ($title=="")) {
		$error_msg="You must enter a valid title!";
	}
	else if((!isset($target)) || ($target=="") || ($target=="http://")) {
		$error_msg="You must enter a valid target URL!";
	}
	else if((!isset($fad)) || ($fad=="") || ($fad=="http://")) {
		$error_msg="You must enter a valid featured ad description!";
	}
	else {
		$sql=$Db1->query("INSERT INTO fads SET title='$title', dsub='".time()."', username='$username', description='$fad', target='$target'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=my_ads&".$url_variables."");
	}
}

if($target=="") {
	$target="http://";
}

$includes[content]="
".iif($settings[adminapproved] ==1,"
<div style=\"background-color: lightblue; border: 1px solid green; margin: 10px;\"><center>WARNING!!!<br>Admin must verify your account manually if your unable to use our member features!</div>")."
".iif($thismemberinfo[confirm] ==1,"
".iif($error_msg,"<script>alert('$error_msg');</script>")."
<div align=\"center\">
<form action=\"index.php?view=account&ac=new_fad&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
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
		<td>Description: </td>
		<td><textarea name=\"fad\">$fad</textarea></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Featured Ad\"></td>
	</tr>
</table>
</div>")."
";
?>
