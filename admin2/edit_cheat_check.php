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
$includes[title]="Edit Cheat Check Trivia";

$sql=$Db1->query("SELECT * FROM cheat_questions WHERE id='$id'");
$temp=$Db1->fetch_array($sql);

if($action == "edit_title") {
	$Db1->query("UPDATE cheat_questions SET question='".addslashes($title)."' WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_cheat_check&id=$id&".$url_variables."");
	exit;
}


if($action == "edit_answers") {
	for($x=0; $x<count($answer_index); $x++) {
		$Db1->query("UPDATE cheat_answers SET answer='".addslashes($answer[$x])."' WHERE id='$answer_index[$x]'");
	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_cheat_check&id=$id&".$url_variables."");
	exit;
}


if($action == "add_answer") {
	$Db1->query("INSERT INTO cheat_answers SET qid='$id', answer='".addslashes($answer)."'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_cheat_check&id=$id&".$url_variables."");
	exit;
}

if($action == "edit_aid") {
	$Db1->query("UPDATE cheat_questions SET aid='$aid' WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_cheat_check&id=$id&".$url_variables."");
	exit;
}

if($action == "delete_answer") {
	$Db1->query("DELETE FROM cheat_answers WHERE id='$aid'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=edit_cheat_check&id=$id&".$url_variables."");
	exit;
}




$sql=$Db1->query("SELECT * FROM cheat_answers WHERE qid='$id'");
if($Db1->num_rows() > 0) {
	for($x=0; $ans=$Db1->fetch_array($sql); $x++) {
		$answers.="
			<input type=\"hidden\" value=\"$ans[id]\" name=\"answer_index[$x]\">
			<input type=\"text\" size=60 name=\"answer[$x]\" value=\"".htmlentities($ans[answer])."\"> 
			<input type=\"submit\" value=\"Edit Answers\"> <a href=\"admin.php?view=admin&ac=edit_cheat_check&action=delete_answer&id=$id&aid=$ans[id]&".$url_variables."\" onclick=\"return confirm('Are you sure you want to delete this?')\">Delete</a><br />";
		$answer_dd.="<option value=\"$ans[id]\"".iif($temp[aid] == $ans[id]," selected=\"selected\"").">$ans[answer]";
	}
}
else {
	$answers="There are currently no answers added to this cheat check question!";
}

$includes[content]="

<form action=\"admin.php?view=admin&ac=edit_cheat_check&action=edit_title&id=$id&".$url_variables."\" method=\"post\">
<b>Question</b><br />
<input type=\"text\" size=60 name=\"title\" value=\"".htmlentities($temp[question])."\"> <input type=\"submit\" value=\"Edit Question\">
</form>

<hr>

<form action=\"admin.php?view=admin&ac=edit_cheat_check&action=edit_answers&id=$id&".$url_variables."\" method=\"post\">
<b>Answers</b><br />
$answers
</form>

<hr>

<form action=\"admin.php?view=admin&ac=edit_cheat_check&action=add_answer&id=$id&".$url_variables."\" method=\"post\">
<b>Add New Answer</b><br />
<input type=\"text\" size=60 name=\"answer\"><input type=\"submit\" value=\"Add Answer\">

</form>

<hr>

<form action=\"admin.php?view=admin&ac=edit_cheat_check&action=edit_aid&id=$id&".$url_variables."\" method=\"post\">
<b>Correct Answer</b><br />
<select name=\"aid\">
	<option value=\"\">
	$answer_dd
</select>
<input type=\"submit\" value=\"Save\">
</form>

";

?>
