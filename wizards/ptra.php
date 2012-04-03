<?
$producttitle="Paid To Read Hits";
//**VS**//$setting[ptra]//**VE**//
//**S**//
if($action == "setptra") {
	if($adoption1 == "newptra") {
		if((!isset($title)) || (strlen($title) < 5)) {
			$err="You must enter a valid title at least 5 letters long!";
		}
		else if(!isset($target)) {
			$err="You must enter a valid target URL!";
		}
		else if(!isset($target)) {
			$err="You must enter valid ad content!";
		}
		else if(is_ad_blocked($target)) {
			$err="Error 382 was returned. Please contact support!";
		}
		else {
			$sql=$Db1->query("INSERT INTO ptrads SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				daily_limit='".addslashes($daily_limit)."',
				upgrade='".addslashes($premOnly)."',
				country='".addslashes($country)."',
				dsub='".time()."',
				credits='0',
				ad='".addslashes($ptra)."',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM ptrads WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistptra") {
           $exsistptra = mysql_real_escape_string($_POST['exsistptra']);
      $sql=$Db1->query("SELECT * FROM ptrads WHERE id='$exsistptra'");
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

$sql=$Db1->query("SELECT * FROM ptrads WHERE username='$username' ORDER BY title");
$currenptrads=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$ptralist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=ptrac&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />

<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]&step=2".iif($samount, "&samount=$samount")."&action=setptra&".$url_variables."\" method=\"post\">
<table>
	".iif($currenptrads>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistptra\" type=\"radio\" name=\"adoption1\" value=\"exsistptra\"".iif($adoption1 != "newptra"," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"exsistptra\">Extend Exsisting Paid Ad</label></strong><br />
			<select name=\"exsistptra\">
				$ptralist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newptra\" type=\"radio\" name=\"adoption1\" value=\"newptra\"".iif(($currenptrads==0) || ($adoption1 == "newptra")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newptra\">Create A New Paid Ad</label></strong><br />
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
					<td><textarea name=\"ptra\" cols=25 rows=5></textarea></td>
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