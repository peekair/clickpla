<?
$includes[title]="Manage FAQs";

if($action == "new_faq") {
	$Db1->query("INSERT INTO help_faqs SET 
		title='".addslashes($question)."',
		cat='$cat',
		answer='".addslashes($answer)."',
		br='$format'
	");
	$Db1->query("UPDATE help_cats SET faqs=faqs+1 WHERE id='$id'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=help&".$url_variables."");
}

if($action == "new_cat") {
	$Db1->query("INSERT INTO help_cats SET
		title='".addslashes($title)."'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=help&".$url_variables."");
}


$sql=$Db1->query("SELECT * FROM help_cats ORDER BY title");
for($x=0; $cat=$Db1->fetch_array($sql); $x++) {
	$catlist.="<option value=\"$cat[id]\">".htmlentities(stripslashes($cat[title]))."";
	$sql2=$Db1->query("SELECT * FROM help_faqs WHERE cat='$cat[id]'");
	$faqs="";
	while($faq=$Db1->fetch_array($sql2)) {
		$faqs.="<option value=\"$faq[id]\">".htmlentities(stripslashes($faq[title]))."";
	}
	$thelist.="
	<tr class=\"tableHL1\">
		<td><b><big>$cat[title]</big></b></td>
		<td align=\"right\" width=75>
			<small>
				<a href=\"admin.php?view=admin&ac=edit_help_cat&id=$cat[id]&".$url_variables."\">Edit</a> :
				<a href=\"admin.php?view=admin&ac=delete_help_cat&id=$cat[id]&".$url_variables."\" onclick=\"return confirm('Are you sure you want to delete this?')\">Delete</a>
			</small>
		</td>
	</tr>
	<tr class=\"tableHL2\"> 
		<td colspan=2 align=\"center\">
		
		<select name=\"faqlist$x\">
			<option value=\"\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			$faqs
		</select>

		<input type=\"button\" value=\"Edit\" onclick=\"if(document.faqform.faqlist$x.value != '') {location.href='admin.php?view=admin&ac=edit_help_faq&id='+document.faqform.faqlist$x.value+'&".$url_variables."'} else {alert('Select a FAQ to edit!')}\">
		<input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this?')) location.href='admin.php?view=admin&ac=delete_help_faq&id='+document.faqform.faqlist$x.value+'&".$url_variables."'\">

		</td>
	</tr>
	
	";
}



$includes[content]="
<form name=\"faqform\">
<table width=\"100%\">
	$thelist
</table>
</form>

<div align=\"center\">
<table>
	<tr>
		<td valign=\"top\">
			<script>
			function validate() {
				if (document.newcat.title.value == '') {
					alert('You must enter the category title');
					return false;
				}
			}
			</script>
			<form action=\"admin.php?view=admin&ac=help&action=new_cat&".$url_variables."\" method=\"post\" name=\"newcat\" onsubmit=\"return validate()\">
			<table>
				<tr>
					<td colspan=2 align=\"center\"><b>New Category</b></td>
				</tr>
				<tr>
					<td>Title: </td>
					<td><input type=\"text\" name=\"title\" value=\"\" size=35></td>
				</tr>
				<tr>
					<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add\"></td>
				</tr>
			</table>
			</form>
		</td>
		<td width=40></td>
		<td valign=\"top\">
			<script>
			function validate2() {
				if (document.newfaq.question.value == '') {
					alert('You must enter the question');
					return false;
				}
				else if (document.newfaq.cat.value == '') {
					alert('You must select a category');
					return false;
				}
				else if (document.newfaq.answer.value == '') {
					alert('You must enter an answer');
					return false;
				}
			}
			</script>
			<form action=\"admin.php?view=admin&ac=help&action=new_faq&".$url_variables."\" method=\"post\" name=\"newfaq\" onsubmit=\"return validate2()\">
			<table>
				<tr>
					<td colspan=2 align=\"center\"><b>New FAQ</b></td>
				</tr>
				<tr>
					<td>Question: </td>
					<td><input type=\"text\" name=\"question\" value=\"\" size=35></td>
				</tr>
				<tr>
					<td>Category: </td>
					<td>
					<select name=\"cat\">
						<option value=\"\">
						$catlist
					</select></td>
				</tr>
				<tr>
					<td>Answer</td>
					<td><textarea name=\"answer\" cols=25 rows=5></textarea><br />
					<input type=\"checkbox\" name=\"format\" value=\"1\" checked=\"checked\"> Convert Returns To Line Breaks
					</td>
				</tr>
				<tr>
					<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add\"></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
</div>


<b>Help</b><br />
	You can use HTML<br />
	You can use PHP variables: <font color=\"blue\">\$variablename</font><br />
	Use If Statements: <font color=\"blue\">{{iif(statement==true,((print me if true)),((print me if false)))}}</font><br />
<b><a href=\"admin.php?view=admin&ac=variables&".$url_variables."\">See list of available variables</a><b>

";

?>



