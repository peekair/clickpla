<?
$producttitle="Paid Email Hits";
//**VS**//$setting[ptr]//**VE**//
//**S**//
if($action == "setptr") {
	if($adoption1 == "newptr") {
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
			$sql=$Db1->query("INSERT INTO emails SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				daily_limit='".addslashes($daily_limit)."',
				upgrade='".addslashes($premOnly)."',
				dsub='".time()."',
				credits='0',
				country='".addslashes($country)."',
				description='".addslashes($ptr)."',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM emails WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistptr") {
      $exsistptr = mysql_real_escape_string($_POST['exsistptr']);
      $sql=$Db1->query("SELECT * FROM emails WHERE id='$exsistptr'");
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

$sql=$Db1->query("SELECT * FROM emails WHERE username='$username' ORDER BY title");
$currenemails=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$ptrlist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=ptrc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />

<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]&step=2".iif($samount, "&samount=$samount")."&action=setptr&".$url_variables."\" method=\"post\">
<table>
	".iif($currenemails>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistptr\" type=\"radio\" name=\"adoption1\" value=\"exsistptr\"".iif($adoption1 != "newptr"," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"exsistptr\">Extend Exsisting Paid Email</label></strong><br />
			<select name=\"exsistptr\">
				$ptrlist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newptr\" type=\"radio\" name=\"adoption1\" value=\"newptr\"".iif(($currenemails==0) || ($adoption1 == "newptr")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newptr\">Create A New Paid Email</label></strong><br />
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
					<td valign=\"top\">Ad:<br /><small><sup>No Html</sup></small></td>
					<td><textarea name=\"ptr\" cols=25 rows=5></textarea></td>
				</tr>
				<tr>
					<td>Target Country: </td>
					<td><select name=\"country\">".targetCountryList()."</select></td>
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