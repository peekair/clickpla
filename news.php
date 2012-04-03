<?
$sql=$Db1->query("SELECT * FROM news ORDER BY dsub DESC");
while($news=$Db1->fetch_array($sql)) {
	$allnews.="
	<h4>
		".stripslashes($news[title])."
		<span class=\"date\">".date('M d, Y', mktime(0,0,$news[dsub],1,1,1970))."</span>
		</font>".iif($permission==7," - <a href=\"index.php?view=admin&ac=delete_news&id=$news[id]&".$url_variables."\">Delete!</a>")."
	</h4>
	<p>".stripslashes($news[news])."</p>
";
}

$includes[content]="
<div class=\"news\">$allnews</div>
";


?>