<?
$producttitle="Guaranteed Signups";
//**VS**//$setting[ptsu]//**VE**//
//**S**//

if(SETTING_PTSU != true) {
	haultscript();
}

if($action == "setptsu") {
	if($adoption1 == "newptsu") {
		if((!isset($title)) || (strlen($title) < 5)) {
			$err="You must enter a valid title at least 5 letters long!";
		}
		else if(!isset($target)) {
			$err="You must enter a valid target!";
		}
		else if(is_ad_blocked($target)) {
			$err="Error 382 was returned. Please contact support!";
		}
		else {
			$sql=$Db1->query("INSERT INTO ptsuads SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				upgrade='".addslashes($premOnly)."',
				pamount='$settings[ptsu_value]',
				country='".addslashes($country)."',
				dsub='".time()."',
				active='".iif($settings[ptsu_require_act]==1,"0","1")."',
				credits='0',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM ptsuads WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistptsu") {
      $exsistptsu = mysql_real_escape_string($_POST['exsistptsu']);
      $sql=$Db1->query("SELECT * FROM ptsuads WHERE id='$exsistptsu'");
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

$sql=$Db1->query("SELECT * FROM ptsuads WHERE username='$username' ORDER BY title");
$currenptsu=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$ptsulist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=ptsuc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />

<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]".iif($samount, "&samount=$samount")."&step=2&action=setptsu&".$url_variables."\" method=\"post\">
<table>
	".iif($currenptsu>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistptsu\" type=\"radio\" name=\"adoption1\" value=\"exsistptsu\"".iif($adoption1 != "newptsu"," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"exsistptsu\">Extend Exsisting Signup Offer</label></strong><br />
			<select name=\"exsistptsu\">
				$ptsulist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newptsu\" type=\"radio\" name=\"adoption1\" value=\"newptsu\"".iif(($currenptsu==0) || ($adoption1 == "newptsu")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newptsu\">Create A New Signup Offer</label></strong><br />
			<table>
				<tr>
					<td>Title: </td>
					<td><input type=\"text\" name=\"title\" value=\"$title\"></td>
				</tr>
				<tr>
					<td>Target Url: </td>
					<td><input type=\"text\" name=\"target\" value=\"$target\"></td>
				</tr>
				<tr>
					<td>Target Country: </td>
					<td><select name=\"country\">".targetCountryList()."</select></td>
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