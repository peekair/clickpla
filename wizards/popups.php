<?
$producttitle="PTP Ad";
//**VS**//$setting[ptp]//**VE**//
//**S**//

if(SETTING_PTP != true) {
	haultscript();
}

if($action == "setpopup") {
	if($adoption1 == "newpopup") {
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
			$sql=$Db1->query("INSERT INTO popups SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				daily_limit='".addslashes($daily_limit)."',
				dsub='".time()."',
				credits='0',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM popups WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistpopup") {
      $exsistpopup = mysql_real_escape_string($_POST['exsistpopup']);
      $sql=$Db1->query("SELECT * FROM popups WHERE id='$exsistpopup'");
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

$sql=$Db1->query("SELECT * FROM popups WHERE username='$username' ORDER BY title");
$currenpopups=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$popuplist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=popupsc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />

<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]".iif($samount, "&samount=$samount")."&step=2&action=setpopup&".$url_variables."\" method=\"post\">
<table>
	".iif($currenpopups>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistpopup\" type=\"radio\" name=\"adoption1\" value=\"exsistpopup\"".iif($adoption1 != "newpopup"," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"exsistpopup\">Extend Exsisting PTP Ad</label></strong><br />
			<select name=\"exsistpopup\">
				$popuplist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newpopup\" type=\"radio\" name=\"adoption1\" value=\"newpopup\"".iif(($currenpopups==0) || ($adoption1 == "newpopup")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newpopup\">Create A New PTP Ad</label></strong><br />
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
					<td>Daily Limit: </td>
					<td><input type=\"text\" name=\"daily_limit\" value=\"$daily_limit\" size=4></td>
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