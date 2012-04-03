<?
$includes[title]="Forum Options";
//**S**//

if($action == "dela") {
	$sql=$Db1->query("DELETE FROM ".addslashes($dels)."");
echo "<font color=\"darkgreen\">Successfully deleted</font>";
}
if($action == "spam") {
	$sql=$Db1->query("DELETE FROM forum_topics WHERE  username='".addslashes($spamuser)."'");
	$sql=$Db1->query("DELETE FROM forum_replys WHERE  username='".addslashes($spamuser)."'");
echo "<font color=\"darkgreen\">Successfully deleted</font>";
}


$totaltopics = mysql_num_rows(mysql_query("SELECT id FROM forum_topics"));
$totalposts = mysql_num_rows(mysql_query("SELECT id FROM forum_replys"));
$totalcat = mysql_num_rows(mysql_query("SELECT id FROM forum_forums"));

//**S**//
$sql=$Db1->query("SELECT COUNT(id) AS total  FROM forum_forums ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+10;
if($start+10 > $ttotal) {$end=$ttotal;}



if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="id";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT * FROM forum_forums  ORDER BY $orderby $type LIMIT $start, 10");
$total_cat=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_cat=$Db1->fetch_array($sql); $x++) {
		$catslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">

					<td NOWRAP=\"NOWRAP\">$this_cat[id]</td>
					<td NOWRAP=\"NOWRAP\">$this_cat[name]</td>
<td NOWRAP=\"NOWRAP\"><a href=admin.php?view=admin&ac=forumsett&action=delete&id=$this_cat[id]>Delete</a></td>

				</tr>
";
	}
}

if($action == "delete") {
	$sql=$Db1->query("DELETE FROM forum_forums WHERE id='$id'");
		header("Location: admin.php?view=admin&ac=forumsett&".$url_variables."");
	}
$includes[content].="
<table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">
    <tr>
<td width=\"45%\"><form method=\"post\" action=\"admin.php?ac=forumsett&action=del&".$url_variables."\">
<table width=\"100%\" border=1 cellpadding=2 cellspacing=\"0\" class=\"tableHL2\">
  <tr>
    <td colspan=\"2\" class=\"tableBD1\">Stats</td>
  </tr>
  <tr>
    <td width=178>Total Topics</td>
    <td width=45>$totaltopics</td>
  </tr>
  <tr>
    <td>Total Posts</td>
    <td>$totalposts</td>
  </tr>
  <tr>
    <td>Total Forums</td>
    <td>$totalcat</td>
  </tr>
</table>
</form>
<br>
<form method=\"post\" action=\"admin.php?ac=forumsett&action=dela&".$url_variables."\">
<table width=\"100%\" border=1 cellpadding=2 cellspacing=\"0\" class=\"tableHL2\">
  <tr>
    <td  class=\"tableBD1\">Clean Forum</td>
  </tr>
  <tr>
    <td><select name=\"dels\" id=\"dels\">
      <option value=\"forum_topics\">Topics</option>
      <option value=\"forum_replys\">Replys</option>
    </select>      <input type=\"submit\" value=\"Delete\"></td>
  </tr>
  <tr>
    <td>* This deletes all of the selected</td>
  </tr>
</table>
</form>
<br>
<form method=\"post\" action=\"admin.php?ac=forumsett&action=spam&".$url_variables."\">
<table width=\"100%\" border=1 cellpadding=2 cellspacing=\"0\" class=\"tableHL2\">
  <tr>
    <td colspan=\"2\" class=\"tableBD1\">Spam Management</td>
    </tr>
  <tr>
    <td colspan=\"2\"><input name=\"spamuser\" type=\"text\" id=\"spamuser\" value=\"Username\" size=\"30\">      
      <input type=\"submit\" value=\"Delete\"></td>
    </tr>
  <tr>
    <td colspan=\"2\">* Delete all topics and posts made by a user</td>
    </tr>
</table>
</form>
<br>
</td>
<td width=\"45%\">
<form method=\"post\" action=\"admin.php?ac=forumsett&action=delete&".$url_variables."\">
<table width=\"500\" border=1 cellpadding=2 cellspacing=\"0\" class=\"tableHL2\">
				<tr class=\"tableBD1\">
<td NOWRAP><a href=\"admin.php?view=admin&ac=forumsett&orderby=cat.id&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b># ID</b> ".$order['forum_forums.id']."</a></td>

<td NOWRAP><a href=\"admin.php?view=admin&ac=forumsett&orderby=cat.cat&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Forum</b> ".$order['forum_forums.name']."</a></td>

<td NOWRAP>Delete</td>
</tr>
				
					$catslisted
				
			</table>
	
";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Forums<br>";
	if($ttotal > 10) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-10;
		$bc.="<a href=\"admin.php?view=admin&ac=forumsett&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+10 < $ttotal)) {$bc.=" :: ";}
	if($start+10 < $ttotal) {
		$start=$start+10;
		$bc.=" <a href=\"admin.php?view=admin&ac=forumsett&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 10) {$bc.=" ]";}
}



$includes[content].=$bc."</td>
";
?>