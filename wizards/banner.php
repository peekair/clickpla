<?
$producttitle="Banner Ad Impressions";
//**S**//
if($action == "setbanner") {
	if($adoption1 == "newbanner") {
		if((!isset($title)) || (strlen($title) < 5)) {
			$err="You must enter a valid title at least 5 letters long!";
		}
		else if((!isset($target)) || ($target=="") || ($target=="http://") || (substr_count($target,"http") == 0)) {
			$err="You must enter a valid target URL!";
		}
		else if((!isset($banner)) || ($banner=="") || ($banner=="http://") || (substr_count($banner,"http") == 0)) {
			$err="You must enter a valid banner URL!";
		}
		else if(is_html($banner) == true) {
			$err="HTML was detected in the banner URL! You must enter only the banner image URL!";
		}
		else if(is_html($target) == true) {
			$err="HTML was detected in the target URL! You must enter only the URL, No HTML is allowed!!";
		}
		else if(is_ad_blocked($target)) {
			$err="Error 382 was returned. Please contact support!";
		}
		else {
			$sql=$Db1->query("INSERT INTO banners SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				banner='".addslashes($banner)."',
				daily_limit='".addslashes($daily_limit)."',
				dsub='".time()."',
				credits='0',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM banners WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistbanner") {
		$exsistbanner = mysql_real_escape_string($_POST['exsistbanner']);
		$sql=$Db1->query("SELECT * FROM banners WHERE id='$exsistbanner'");
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

$sql=$Db1->query("SELECT * FROM banners WHERE username='$username' ORDER BY title");
$currenbanners=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$bannerlist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=bannerc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />

<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]&step=2".iif($samount, "&samount=$samount")."&action=setbanner&".$url_variables."\" method=\"post\">
<table>
	".iif($currenbanners>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistbanner\" type=\"radio\" name=\"adoption1\" value=\"exsistbanner\"".iif($adoption1 != "newbanner"," checked=\"checked\"")."></td>
		<td>
			<label for=\"exsistbanner\"><strong>Extend Existing Banner Ad</strong></label><br />
			<select name=\"exsistbanner\">
				$bannerlist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newbanner\" type=\"radio\" name=\"adoption1\" value=\"newbanner\"".iif(($currenbanners==0) || ($adoption1 == "newbanner")," checked=\"checked\"")."></td>
		<td>
			<label for=\"newbanner\"><strong>Create A New Banner Ad</strong></label><br />
			<table>
				<tr>
					<td>Title: </td>
					<td><input type=\"text\" name=\"title\" value=\"".htmlentities(stripslashes($title))."\"></td>
				</tr>
				<tr>
					<td>Target Url: </td>
					<td><input type=\"text\" name=\"target\" value=\"".htmlentities(stripslashes($target))."\"></td>
				</tr>
				<tr>
					<td>Banner Location Url: </td>
					<td><input type=\"text\" name=\"banner\" value=\"".htmlentities(stripslashes($banner))."\"></td>
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