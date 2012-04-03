<?
//##############################################
//#            AURORAGPT Script Copyright owned by Mike Pratt              #
//#                        ALL RIGHTS RESERVED 2007-2009                        #
//#                                                                                                 #
//#        Any illegal use of this script is strictly prohibited unless          #
//#        permission is given by the owner of this script.  To sell          #
//#        this script you must have a resellers license. Your site          #
//#        must also use a unique encrypted license key for your         #
//#        site. Your site must also have site_info module and             #
//#        key.php file must be in the script unedited. Otherwise         #
//#        it will be considered as unlicensed and can be shut down    #
//#        legally by Illusive Web Services. By using AuroraGPT       #
//#        script you agree not to copy infringe any of the coding     #
//#        and or create a clone version is also copy infringement   #
//#        and will be considered just that and legal action will be   #
//#        taken if neccessary.                                                    #
//#########################################//
$includes[title] = "Featured Links Manager";

//**S**//
if ($action == "add") {
    $sql = $Db1->query("INSERT INTO flinks SET 
		title='" . htmlentities($title) . "',
		target='$target',
		username='$user',
		dend='" . mktime(0, 0, 0, $proendmm, $proenddd, $proendyy) . "'
		");
    $Db1->sql_close();
    header("Location: admin.php?view=admin&ac=flinks&" . $url_variables . "");
}


if (($step == "") && ($search == 1)) {
    header("Location: admin.php?view=admin&ac=flinks&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&" .
        $url_variables . "");
    exit;
}

if ($search == 1) {
    $search_str2 = explode(" ", $search_str);
    for ($x = 0; $x < count($search_str2); $x++) {
        $conditions .= " flinks.$search_by LIKE '%$search_str2[$x]%' ";
        if ($x < (count($search_str2) - 1)) {
            $conditions .= " AND ";
        }
    }
    $search_var = "&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql = $Db1->query("SELECT COUNT(id) AS total FROM flinks " . iif($conditions,
    "WHERE $conditions") . "");
$thet = $Db1->fetch_array($sql);
$ttotal = $thet[total];

if ($start == "") {
    $start = 0;
}
$end = $start + 25;
if ($start + 25 > $ttotal) {
    $end = $ttotal;
}


if ($type == "")
    $type = "ASC";
if ($type == "DESC")
    $newtype = "ASC";
if ($type == "ASC")
    $newtype = "DESC";

if ($orderby == "")
    $orderby = "flinks.title";


if ($orderby == "flinks.id") {
    $ordernum = 1;
}
if ($orderby == "flinks.title") {
    $ordernum = 2;
}
if ($orderby == "flinks.username") {
    $ordernum = 3;
}
if ($orderby == "flinks.dend") {
    $ordernum = 5;
}
if ($orderby == "flinks.clicks") {
    $ordernum = 6;
}


$order[$ordernum] = "<img src=\"images/" . "$type" . ".gif\" border=0>";

$sql = $Db1->query("SELECT flinks.* FROM flinks WHERE " . iif($conditions, "$conditions",
    "1") . " ORDER BY $orderby $type LIMIT $start, 25");
$total_members = $Db1->num_rows();
if ($Db1->num_rows() != 0) {
    for ($x = 0; $this_flink = $Db1->fetch_array($sql); $x++) {
        $userslisted .= "
				<tr>
					<td>$this_flink[id]</td>
					<td><a href=\"$this_flink[target]\" target=\"_blank\">*</a><a href=\"admin.php?view=admin&ac=edit_flink&id=" .
            $this_flink[id] . "&s=$s&direct=flinks&start=$start&type=$type&orderby=$orderby" .
            iif($search_var, "$search_var") . "&" . $url_variables . "\">*" . ucwords(strtolower
            (stripslashes($this_flink[title]))) . "</a></td>
					<td><a href=\"admin.php?view=admin&ac=edit_user&uname=" . $this_flink[username] .
            "&s=$s&direct=flinks&start=$start&type=$type&orderby=$orderby" . iif($search_var,
            "$search_var") . "&" . $url_variables . "\">$this_flink[username]</a></td>
					<td>$this_flink[clicks]</td>
					<td>".date('m/d/y', @mktime(0,0,$this_flink[dend],1,1,1970))."</td>
				</tr>
";
    }
} else {
    $userslisted = "
			<tr>
				<td colspan=6 align=center class=\"tableHL2\">No Results!</td>
			</tr>
	";
}
$includes[content] .= "
<div align=\"center\">
<form action=\"admin.php?view=admin&ac=flinks&search=1\" method=\"post\">
<table>
	<tr>
		<td align=\"center\">Search <input type=\"text\" name=\"search_str\" value=\"$search_str\">
		<select name=\"search_by\">
			<option value=\"username\" " . iif($search_by == "username", "SELECTED") .
    ">Username
			<option value=\"id\" " . iif($search_by == "id", "SELECTED") . ">Id
			<option value=\"title\" " . iif($search_by == "title", "SELECTED") . ">Title
			<option value=\"target\" " . iif($search_by == "target", "SELECTED") . ">Url
		</select>
		<br /><input type=\"submit\" value=\"Search\"></td>
	</tr>
</table>
</form>


<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=flinks&orderby=flinks.id&type=$newtype" .
    iif($search_var, "$search_var") . "&" . $url_variables . "\">Id " . $order[1] .
    "</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=flinks&orderby=flinks.title&type=$newtype&start=$start" .
    iif($search_var, "$search_var") . "&" . $url_variables . "\"><b>Title</b> " . $order[2] .
    "</a></th>
		<th><a href=\"admin.php?view=admin&ac=flinks&orderby=flinks.username&type=$newtype&start=$start" .
    iif($search_var, "$search_var") . "&" . $url_variables . "\"><b>Username</b> " .
    $order[3] . "</a></th>
		<th><a href=\"admin.php?view=admin&ac=flinks&orderby=flinks.clicks&type=$newtype&start=$start" .
    iif($search_var, "$search_var") . "&" . $url_variables . "\"><b>Clicks</b> " . $order[6] .
    "</a></th>
		<th><a href=\"admin.php?view=admin&ac=flinks&orderby=flinks.dend&type=$newtype&start=$start" .
    iif($search_var, "$search_var") . "&" . $url_variables . "\"><b>Date</b> " . $order[5] .
    "</a></th>
	</tr>
	
		$userslisted
	
</table>

";
if ($ttotal != 0) {
    $bc .= ($start + 1) . " Through " . $end . " Of $ttotal $tut_type Featured Links<br />";
    if ($ttotal > 25) {
        $bc .= "[ ";
    }
    if ($start > 9) {
        $bstart = $start - 25;
        $bc .= "<a href=\"admin.php?view=admin&ac=flinks&start=$bstart&orderby=$orderby&type=$type" .
            iif($search_var, "$search_var") . "&" . $url_variables . "\">Back</a>";
    }
    if (($start > 9) && ($start + 25 < $ttotal)) {
        $bc .= " :: ";
    }
    if ($start + 25 < $ttotal) {
        $start = $start + 25;
        $bc .= " <a href=\"admin.php?view=admin&ac=flinks&start=$start&orderby=$orderby&type=$type" .
            iif($search_var, "$search_var") . "&" . $url_variables . "\">Next</a> ";
    }
    if ($ttotal > 25) {
        $bc .= " ]";
    }
}


$includes[content] .= $bc . "</div>


<br /><br />

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=flinks&action=add&" . $url_variables . "\" method=\"post\" onSubmit=\"submitonce(this)\">
<b>New Link Ad</b>
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
		<td>Username: </td>
		<td><input type=\"text\" name=\"user\" value=\"$username\"></td>
	</tr>
				<tr>
					<td>Expire: (mm/dd/yy)</td>
					<td>
						";

if ($adinfo[dend] == "") {
    $adinfo[dend] = time() + 2764800;
}

$thedate = explode("/", date('d/m/y', mktime(0, 0, $adinfo[dend], 1, 1, 1970)));

$includes[content] .= "<select name=\"proendmm\">";
for ($x = 1; $x <= 12; $x++) {
    $includes[content] .= "
								<option value=\"$x\" " . iif($thedate[1] == $x, " selected") . ">$x
							";
}
$includes[content] .= "</select>";

$includes[content] .= "<select name=\"proenddd\">";
for ($x = 1; $x <= 31; $x++) {
    $includes[content] .= "
								<option value=\"$x\" " . iif($thedate[0] == $x, " selected") . ">$x
							";
}
$includes[content] .= "</select>";

$includes[content] .= "<select name=\"proendyy\">";
for ($x = 8; $x <= 19; $x++) {
    $includes[content] .= "
								<option value=\"$x\" " . iif($thedate[2] == $x, " selected") . ">" . ($x <
        10 ? "200" : "20") . "$x
							";
}
$includes[content] .= "</select>";

$includes[content] .= "
					</td>
				</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Featured Link\"></td>
	</tr>
</table>
</form>
</div>
";
//**E**//


?>
