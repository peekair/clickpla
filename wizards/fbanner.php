<?
$producttitle="Featured Banner Ad Impressions";
//**S**//
if($action == "setfbanner") {
	if($adoption1 == "newfbanner") {
		if((!isset($title)) || (strlen($title) < 5)) {
			$err="You must enter a valid title at least 5 letters long!";
		}
		else if((!isset($target)) || ($target=="") || ($target=="http://") || (substr_count($target,"http") == 0)) {
			$err="You must enter a valid target URL!";
		}
		else if((!isset($fbanner)) || ($fbanner=="") || ($fbanner=="http://") || (substr_count($fbanner,"http") == 0)) {
			$err="You must enter a valid banner URL!";
		}
		else if(is_html($fbanner) == true) {
			$err="HTML was detected in the banner URL! You must enter only the banner image URL!";
		}
		else if(is_html($target) == true) {
			$err="HTML was detected in the target URL! You must enter only the URL, No HTML is allowed!!";
		}
		else if(is_ad_blocked($target)) {
			$err="Error 382 was returned. Please contact support!";
		}
		else {
			$sql=$Db1->query("INSERT INTO fbanners SET
				username='$username',
				title='".addslashes($title)."',
				target='".addslashes($target)."',
				banner='".addslashes($fbanner)."',
				dsub='".time()."',
				credits='0',
				pref='$order[order_id]'
			");
			$sql=$Db1->query("SELECT * FROM fbanners WHERE pref='$order[order_id]' ORDER BY id DESC LIMIT 1");
			$pad=$Db1->fetch_array($sql);
		}
	}
	else if($adoption1 == "exsistfbanner") {
		$sql=$Db1->query("SELECT * FROM fbanners WHERE id='$exsistfbanner'");
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

$sql=$Db1->query("SELECT * FROM fbanners WHERE username='$username' ORDER BY title");
$currenfbanners=$Db1->num_rows();
while($temp=$Db1->fetch_array($sql)) {
	$fbannerlist.="<option value=\"$temp[id]\">$temp[title]\n";
}

$includes[content]="
".iif(isset($err),"<script>alert('$err');</script>")."
<div align=\"center\">

<a href=\"index.php?view=account&ac=buywizard&step=2&ptype=fbannerc&".$url_variables."\">Click Here To Order Account Credits Only</a>
<br />Or<br />


<form action=\"index.php?view=account&ac=buywizard&pid=$order[order_id]&step=2".iif($samount, "&samount=$samount")."&action=setfbanner&".$url_variables."\" method=\"post\">
<table>
	".iif($currenfbanners>0,"
	<tr>
		<td valign=\"top\"><input id=\"exsistfbanner\" type=\"radio\" name=\"adoption1\" value=\"exsistfbanner\"".iif($adoption1 != "newfbanner"," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"exsistfbanner\">Extend Exsisting Featured Banner Ad</label></strong><br />
			<select name=\"exsistfbanner\">
				$fbannerlist
			</select>
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	")."
	<tr>
		<td valign=\"top\"><input id=\"newfbanner\" type=\"radio\" name=\"adoption1\" value=\"newfbanner\"".iif(($currenfbanners==0) || ($adoption1 == "newfbanner")," checked=\"checked\"")."></td>
		<td>
			<strong><label for=\"newfbanner\">Create A New Featured Banner Ad</label></strong><br />
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
					<td><input type=\"text\" name=\"fbanner\" value=\"".htmlentities(stripslashes($fbanner))."\"></td>
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