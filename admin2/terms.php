<?
$includes[title]="Add To Terms Of Service";
//**S**//
if($action == "add") {
	$sql=$Db1->query("INSERT INTO terms SET title='".addslashes($title)."' , imglink=' ".$settings[base_url]."/images/icons/termsicon.png' , dsub='".time()."', terms='".addslashes($terms)."'");
}



$sql=$Db1->query("SELECT * FROM terms ORDER BY id");

	
		$sql2=$Db1->query("SELECT * FROM terms");
		$faqs="";
	while($faq=$Db1->fetch_array($sql2)) {
		$faqs.="<option value=\"$faq[id]\">".htmlentities(stripslashes($faq[title]))."";
	}
	
	$thelist.="
	<tr class=\"tableHL1\">
		<td><b><big>Terms</big></b></td>
					
		
	</tr>
	<tr class=\"tableHL2\"> 
		<td colspan=2 align=\"center\">
		
		<select name=\"faqlist$x\">
			<option value=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			$faqs
		</select>

		<input type=\"button\" value=\"Edit\" onclick=\"if(document.faqform.faqlist$x.value != '') {location.href='admin.php?view=admin&ac=edit_terms&id='+document.faqform.faqlist$x.value+'&".$url_variables."'} else {alert('Select a Term to edit!')}\">
		<input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this?')) location.href='admin.php?view=admin&ac=delete_terms&id='+document.faqform.faqlist$x.value+'&".$url_variables."'\">

		</td>
	</tr>
	
	";



$includes[content]="
<form name=\"faqform\">
<table width=\"100%\">
	$thelist
</table>
</form>

<form method=\"post\" action=\"admin.php?view=admin&ac=terms&action=add&".$url_variables."\">
<table>
	<tr>
		<td>Title OF Terms</td>
		<td><input type=\"text\" name=\"title\"></td>
	</tr>
	<tr>
		<td colspan=2>Terms:<br><textarea name=\"terms\" cols=25 rows=5></textarea></td>
	</tr>
	<tr>
		<td align=\"center\" colspan=2><input type=\"submit\" value=\"Add Term\"></td>
	</tr>
</table>
</form>
";
//**E**//
?>