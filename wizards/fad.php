<?
$producttitle="Featured Ad Impressions";
//**S**//
if($action == "setfad") {
	if($adoption1 == "newfad") {
		if((!isset($title)) || (strlen($title) < 5)) {
			$err="You must enter a valid title at least 5 letters long!";
		}
		else if(!isset($target)) {
			$err="You must enter a valid target URL!";
		}
		else if(is_ad_blocked($target)) {
			$err="Error 382 was returned. Please contact support!";
		}
		else {
			$sql=$Db1->query("INSERT INTO fads SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				daily_limit='".addslashes($daily_limit)."',
				upgrade='".addslashes($premOnly)."',
				dsub='".time()."',
				credits='0',
				description='".addslashes($fad)."',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM fads WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistfad") {
		$exsistfad = mysql_real_escape_string($_POST['exsistfad']);
		$sql=$Db1->query("SELECT * FROM fads WHERE id='$exsistfad'");
		$pad=$Db1->fetch_array($sql);
	}
	if(!isset($err)) {
		$sql=$Db1->query("UPDATE orders SET
			ad_id='$pad[id]'
			WHERE order_id='$order[order_id]'
		");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=buywizard&step=3".iif($samount, "&samount=$samount")."&pid=$order[order_id]&".$url_variables."");
	}
}

$sql=$Db1->query("SELECT * FROM fads WHERE username='$username' ORDER BY title");
$currenfads=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$fadlist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<script language=\"JavaScript\">
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
		field.value = field.value.substring(0, maxlimit);
	else 
		countfield.value = maxlimit - field.value.length;
}
</script>

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=fadc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />


<form name=\"form\" action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]&step=2".iif($samount, "&samount=$samount")."&action=setfad&".$url_variables."\" method=\"post\">
<table>
	".iif($currenfads>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistfad\" type=\"radio\" name=\"adoption1\" value=\"exsistfad\"".iif($adoption1 != "newfad"," checked=\"checked\"")."></td>
		<td>
			<label for=\"exsistfad\"><strong>Extend Exsisting Featured Ad</strong></label><br />
			<select name=\"exsistfad\">
				$fadlist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newfad\" type=\"radio\" name=\"adoption1\" value=\"newfad\"".iif(($currenfads==0) || ($adoption1 == "newfad")," checked=\"checked\"")."></td>
		<td>
			<label for=\"newfad\"><strong>Create A New Featured Ad</strong></label><br />
			<table>
				<tr>
					<td>Title: </td>
					<td>
						<input type=\"text\" name=\"title\" maxlength=$settings[fad_title_limit] onKeyDown=\"textCounter(this.form.title,this.form.titlecount,$settings[fad_title_limit]);\" onKeyUp=\"textCounter(this.form.title,this.form.titlecount,$settings[fad_title_limit]);\">
						<input type=\"text\" name=\"titlecount\" size=2 maxlength=2 value=\"$settings[fad_title_limit]\">
					</td>
				</tr>
				<tr>
					<td>Target Url: </td>
					<td><input type=\"text\" name=\"target\"><br /><small>URL must include <strong>http://</strong></small></td>
				</tr>
				<tr>
					<td valign=\"top\">Ad:<br /><small><sup>No Html</sup></small>
						<div align=\"center\"></div>
					</td>
					<td><textarea name=\"fad\" cols=25 rows=5 maxlength=$settings[fad_title_limit] onKeyDown=\"textCounter(this.form.fad,this.form.desccount,$settings[fad_desc_limit]);\" onKeyUp=\"textCounter(this.form.fad,this.form.desccount,$settings[fad_desc_limit]);\"></textarea></td>
				</tr>
				<tr>
					<td>Daily Limit: </td>
					<td><input type=\"text\" name=\"daily_limit\" value=\"$daily_limit\" size=4></td>
				</tr>
				<tr>
					<td>Premium Members Only? </td>
					<td><input type=\"checkbox\" name=\"premOnly\" value=\"1\"></td>
				</tr>
			</table>
			<div align=\"center\">
			<input type=\"text\" name=\"desccount\" size=2 maxlength=2 value=\"$settings[fad_desc_limit]\"> Characters Left
			</div>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Next Step =>\"></td>
	</tr>
</table>
</form>
</div>
";
//**E**//
?>