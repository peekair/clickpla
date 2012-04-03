<?
$producttitle="Featured Link Rotation";
//**S**//
if($action == "setflink") {
	if($adoption1 == "newflink") {
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
			$sql=$Db1->query("INSERT INTO flinks SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				upgrade='".addslashes($premOnly)."',
				dsub='".time()."',
				dend='".time()."',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM flinks WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistflink") {
		$exsistflink = mysql_real_escape_string($_POST['exsistflink']);
		$sql=$Db1->query("SELECT * FROM flinks WHERE id='$exsistflink'");
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

$sql=$Db1->query("SELECT * FROM flinks WHERE username='$username' ORDER BY title");
$currenflinks=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$flinklist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">
<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]".iif($samount, "&samount=$samount")."&step=2&action=setflink&".$url_variables."\" method=\"post\">
<table>
	".iif($currenflinks>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistflink\" type=\"radio\" name=\"adoption1\" value=\"exsistflink\"".iif($adoption1 != "newflink"," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"exsistflink\">Extend Exsisting Featured Link</label></strong><br />
			<select name=\"exsistflink\">
				$flinklist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newflink\" type=\"radio\" name=\"adoption1\" value=\"newflink\"".iif(($currenflinks==0) || ($adoption1 == "newflink")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newflink\">Create A New Featured Link</label></strong><br />
			<table>
				<tr>
					<td>Title: </td>
					<td><input type=\"text\" name=\"title\"></td>
				</tr>
				<tr>
					<td>Target Url: </td>
					<td><input type=\"text\" name=\"target\"></td>
				</tr>
				<tr>
					<td>Premium Members Only? </td>
					<td><input type=\"checkbox\" name=\"premOnly\" value=\"1\"></td>
				</tr>
			</table>
			<div align=\"center\"><small>URL's must include <strong>http://</strong></small></div>
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