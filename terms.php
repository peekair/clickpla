<?
$sql=$Db1->query("SELECT * FROM terms ORDER BY dsub DESC");
while($terms=$Db1->fetch_array($sql)) {
	$allterms.="
<h4><img src=\"".stripslashes($terms[imglink])."\" border=\"0\" height=\"10\" width=\"10\"> ".stripslashes($terms[title])."</h2>
".stripslashes($terms[terms])."".iif($permission==7," <a href=\"index.php?view=admin&ac=delete_terms&id=$terms[id]&".$url_variables."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"images/delete.gif\" border=\"0\" height=\"15\" width=\"15\">Delete</a><br><br>")."
<hr>";
}

$includes[content]="
<hr><br>
$allterms
<br><br>
";

?>