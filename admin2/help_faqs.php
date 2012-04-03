<?
$includes[title]="Help FAQs";
//**S**//
if($action == "new_faq") {
	$sql=$Db1->query("INSERT INTO help_faqs SET title='".addslashes($faq)."', answer='".addslashes($answer)."', cat='$cat'");
	$sql=$Db1->query("UPDATE help_cats SET faqs=faqs+1 WHERE id='$cat'");
}

$sql=$Db1->query("SELECT * FROM help_cats ORDER BY title");
while($cat=$Db1->fetch_array($sql)) {
	$catlist.="
	<option value=\"$cat[id]\">$cat[title]";
}



$includes[content]="
<form action=\"admin.php?view=admin&ac=help_faqs&action=new_faq\" method=\"post\">
<select name=\"cat\">
	$catlist
</select><br />
<textarea name=\"faq\" cols=\"50\" rows=\"3\">Question</textarea><br />
<textarea name=\"answer\" cols=\"50\" rows=\"7\">Answer</textarea><br />
<input type=\"submit\" value=\"Add Faq\">
</form>";
//**E**//
?>
