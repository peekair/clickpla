<?
$producttitle="Link Ad";
//**VS**//$setting[ptc]//**VE**//
//**S**//
if($action == "setlink") {
	if($adoption1 == "newlink") {
		if((!isset($title)) || (strlen($title) < 5)) {
			$err="You must enter a valid title at least 5 letters long!";
		}
		else if(!isset($target)) {
			$err="You must enter a valid target!";
		}
		else if(is_ad_blocked($target)) {
			$err="Error 382 was returned. Please contact support!";
        }
       else if (($daily_limit) <= "24" && ($daily_limit != "0")) {
         		$err="Your add must have daily limit of at least 25 clicks, or leave 0 for unlimited!";
        }
		else {
			$sql=$Db1->query("INSERT INTO ads SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
targetban='".addslashes($targetban)."',
				daily_limit='".addslashes($daily_limit)."',
				upgrade='".addslashes($premOnly)."',
				country='".addslashes($country)."',
				dsub='".time()."',
				credits='0',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM ads WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistlink") {
        $exsistlink = mysql_real_escape_string($_POST['exsistlink']);
		$sql=$Db1->query("SELECT * FROM ads WHERE id='$exsistlink'");
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

$sql=$Db1->query("SELECT * FROM ads WHERE username='$username' and class!='P' ORDER BY title");
$currenlinks=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$linklist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=linkc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />

<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]".iif($samount, "&samount=$samount")."&step=2&action=setlink&".$url_variables."\" method=\"post\">
<table>
	".iif($currenlinks>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistlink\" type=\"radio\" name=\"adoption1\" value=\"exsistlink\"".iif($adoption1 != "newlink"," checked=\"checked\"")."></td>
		<td>
			<label for=\"exsistlink\"><strong>Extend Exsisting Link Ad</strong></label><br />
			<select name=\"exsistlink\">
				$linklist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newlink\" type=\"radio\" name=\"adoption1\" value=\"newlink\"".iif(($currenlinks==0) || ($adoption1 == "newlink")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newlink\">Create A New Link Ad</label></strong><br />
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
					<td>PTC Banner Url: </td>
					<td><input type=\"text\" name=\"targetban\" value=\"$targetban\"></td>
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