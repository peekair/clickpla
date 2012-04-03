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
$includes[title]="Special Manager";
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
//**S**//
if($action == "add") {
		$sql=$Db1->query("INSERT INTO specials SET 
		title='".htmlentities($mtitle)."',
		price='$mprice',
		packages='$mpackages',
		`order`='$morder',
		active='$mactive',
		dsub='".time()."'
			");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=specials&".$url_variables."");
}

if($action == "order") {
	for($x=0; $x<count($ind); $x++) {
		$sql=$Db1->query("UPDATE specials SET `order`='$orders[$x]' WHERE id='$ind[$x]'");
	}
}

if($action == "save") {
	$settings["special_homepage"]		=	"$special_homepage";
	$settings["special_prices"]			=	"$special_prices";

	include("admin2/settings/update.php");
	updatesettings($settings);

	$Db1->query("UPDATE specials SET `show`='0'");
	$Db1->query("UPDATE specials SET `show`='1' WHERE id='$spshow'");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=specials&".$url_variables."");
}

if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=specials&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" specials.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM specials ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="specials.title";


if($orderby == "specials.id") {$ordernum=1;}
if($orderby == "specials.title") {$ordernum=2;}
if($orderby == "specials.price") {$ordernum=3;}
if($orderby == "specials.dsub") {$ordernum=4;}
if($orderby == "specials.time_type") {$ordernum=5;}
if($orderby == "specials.active") {$ordernum=6;}
if($orderby == "specials.order") {$ordernum=7;}
if($orderby == "specials.buys") {$ordernum=8;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT specials.* FROM specials WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type");
$total_specials=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $special=$Db1->fetch_array($sql); $x++) {
		$userslisted .= "
				<tr>
					<td>$special[id]</td>
					<td><a href=\"admin.php?view=admin&ac=edit_special&id=".$special[id]."&s=$s&direct=specials&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">".$special[title]." * </a></td>
					<td>".date('M d', mktime(0,0,$special[dsub],1,1,1970))."</td>
					<td>$special[buys]</td>
					<td>$cursym $special[price]</td>
					<td>".iif($special[active]==1,"Yes","No")."</td>
					".iif($special[active]==1,"
						<td>
							<input type=\"hidden\" value=\"$special[id]\" name=\"ind[$x]\">
							<input type=\"text\" name=\"orders[$x]\" value=\"$special[order]\" size=2>
						</td>
					")."
				</tr>
";
	}
}
else {
	$userslisted="
			<tr>
				<td colspan=8 align=center class=\"tableHL2\">No Results!</td>
			</tr>
	";
}
	$includes[content].="
<div align=\"center\">

<form action=\"admin.php?view=admin&ac=specials&action=order&".$url_variables."\" method=\"post\">

<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=specials&orderby=specials.id&type=$newtype".iif($search_var,"$search_var")."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=specials&orderby=specials.title&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=specials&orderby=specials.dsub&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Date</b> ".$order[4]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=specials&orderby=specials.buys&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Buys</b> ".$order[8]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=specials&orderby=specials.price&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Price</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=specials&orderby=specials.active&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Sell?</b> ".$order[6]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=specials&orderby=specials.order&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Order</b> ".$order[7]."</a></th>
	</tr>
		$userslisted
</table>

			
<div align=\"right\"><input type=\"submit\" value=\"Update Order\"></div>
</form>
";

$sql=$Db1->query("SELECT * FROM specials ORDER BY `order`");
while($temp = $Db1->fetch_array($sql)) {
	$speciallist.="<option value=\"$temp[id]\"".iif($temp[show]==1," selected=\"selected\"").">$temp[title]\n";
}

$includes[content].="</div>

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=specials&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<b>New Special Ad</b>
<table>
	<tr>
		<td>Title: </td>
		<td><input type=\"text\" name=\"mtitle\"></td>
	</tr>
	<tr>
		<td>Price: </td>
		<td>$cursym <input type=\"text\" name=\"mprice\" value=\"\" size=5></td>
	</tr>
	<tr>
		<td>Packages: </td>
		<td><input type=\"text\" name=\"mpackages\" value=\"1,2,3,4,5,6,7,8,9,10\"></td>
	</tr>
	<tr>
		<td>Order: </td>
		<td><input type=\"text\" name=\"morder\" value=\"\" size=3></td>
	</tr>
	<tr>
		<td>Sell? </td>
		<td><input type=\"checkbox\" name=\"mactive\" value=\"1\" checked=\"checked\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Special\"></td>
	</tr>
</table>
</form>

<br />


<form action=\"admin.php?view=admin&ac=specials&action=save&".$url_variables."\" method=\"post\">
<b>Special Preview</b><br />
Display On Homepage: <input type=\"checkbox\" name=\"special_homepage\" value=\"1\"".iif($settings[special_homepage]==1," checked=\"checked\"")."><br />
Display On Prices Page: <input type=\"checkbox\" name=\"special_prices\" value=\"1\"".iif($settings[special_prices]==1," checked=\"checked\"")."><br />
Special To Show: 
<select name=\"spshow\">
$speciallist
</select><br />
<input type=\"submit\" value=\"Save\">

</form>

</div>

";
//**E**//
?>
