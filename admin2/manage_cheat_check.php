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
$includes[title]="Manage Cheat Check Trivia";

if($action == "add") {
	$Db1->query("INSERT INTO cheat_questions SET question='".addslashes($title)."'");
	$sql=$Db1->query("SELECT * FROM cheat_questions WHERE question='".addslashes($title)."'");
	$t=$Db1->fetch_array($sql);
	$id=$t[id];
	if($id != "") {
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=edit_cheat_check&id=$id&".$url_variables."");
		exit;
	}
	else {
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=manage_cheat_check&".$url_variables."");
		exit;
	}
}

if($action == "delete") {
	$sql=$Db1->query("DELETE FROM cheat_questions WHERE id='$id'");
	$sql=$Db1->query("DELETE FROM cheat_answers WHERE qid='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=manage_cheat_check&".$url_variables."");
	exit;
}


$sql=$Db1->query("SELECT * FROM cheat_questions ORDER BY id");
while($temp=$Db1->fetch_array($sql)) {
	$list.="
	<tr>
		<td><li>$temp[question]".iif($temp[question]=="","No Title...")."</td>
		<td width=\"40\"></td>
		<td align=\"right\">
			<a href=\"admin.php?view=admin&ac=edit_cheat_check&id=$temp[id]&".$url_variables."\">Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;
			<a href=\"admin.php?view=admin&ac=manage_cheat_check&id=$temp[id]&action=delete&".$url_variables."\" onclick=\"return confirm('Are you sure you want to delete this?')\">Delete</a>
		</td>
	</tr>
	";
}

$includes[content]="

<table>
	$list
</table>

<br />
<hr>
<form action=\"admin.php?view=admin&ac=manage_cheat_check&action=add&".$url_variables."\" method=\"post\">
<b>Add New Cheat Check Question</b><br />
<input type=\"text\" size=60 name=\"title\"> <input type=\"submit\" value=\"Add Question\">

</form>

";


?>
