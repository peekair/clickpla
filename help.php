<?
$includes[title]="FAQs";

if(isset($faq)) { ################################################################## View FAQ
	$Db1->query("UPDATE help_faqs SET views=views+1 WHERE id='$faq'");
	$sql=$Db1->query("SELECT * FROM help_faqs WHERE id='$faq'");
	$answer=$Db1->fetch_array($sql);
	$temp=stripslashes($answer[answer]);
	$temp=str_replace('"','&&', $temp);
	$temp=iif($answer[br]==1,nl2br($temp),$temp);
	$temp=str_replace('{{','".', $temp);
	$temp=str_replace('}}','."', $temp);
	$temp=str_replace('((','"', $temp);
	$temp=str_replace('))','"', $temp);
	$temp="\$theanswer = \"".$temp."\";";
	eval($temp);
	$theanswer=str_replace('&&','"', $theanswer);
	$faqs="<h4>".stripslashes($answer[title])."</h4><p>".$theanswer."</p>";
}
else if(isset($cat)) { ################################################################## View Category
	$sql=$Db1->query("SELECT * FROM help_faqs WHERE cat='$cat'");
	while($faq=$Db1->fetch_array($sql)) {
		$content.="<li><a href=\"index.php?view=help&faq=$faq[id]&".$url_variables."\">".stripslashes($faq[title])."</a></li>";
	}
	$sql=$Db1->query("SELECT * FROM help_cats WHERE id='$cat'");
	$temp=$Db1->fetch_array($sql);
	$faqs="<h4>$temp[title]</h4><ul>$content</ul>
";
}
else { ################################################################## Top FAQS
	$sql=$Db1->query("SELECT * FROM help_faqs ORDER BY views DESC LIMIT 10");
	while($temp=$Db1->fetch_array($sql)) {
		$tops.="<li><a href=\"index.php?view=help&faq=$temp[id]&".$url_variables."\">".parse_link(stripslashes($temp[title]),50)."</a></li>";
	}
	$faqs="<h4>Top FAQs</h4><ul>$tops</ul>";

}

$sql=$Db1->query("SELECT * FROM help_cats ORDER BY title");
while($cat_temp=$Db1->fetch_array($sql)) {
	$categories.="<li><a href=\"index.php?view=help&cat=$cat_temp[id]&".$url_variables."\">".stripslashes($cat_temp[title])."</a></li>";
}
$contents="
	<h4>Categories</h4>
	<ul>$categories</ul>
";


$includes[content] = "

<div class=\"faq\">
	<div class=\"catCont\">$contents</div>
	<div class=\"faqCont\">$faqs</div>
	<div class=\"clear\">Having Trouble? <br /><a href=\"index.php?view=contact&".$url_variables."\">Contact Us</a></div>
</div>



";

?>