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
$includes[title]="Membership Manager";

//**S**//
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
if($action == "add") {
		$sql=$Db1->query("INSERT INTO memberships SET 
		title='".htmlentities($mtitle)."',
		time_type='$mtype',
		downline_earns='$mdle',
		price='$mprice',
		packages='$mpackages',
		`order`='$morder',
		active='$mactive',
		purchase_bonus='$purchase_bonus',
		upgrade_bonus='$upgrade_bonus',
		ptp='$ptp',
		dsub='".time()."'
			");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=memberships&".$url_variables."");
}

if($action == "order") {
	for($x=0; $x<count($ind); $x++) {
		$sql=$Db1->query("UPDATE memberships SET `order`='$orders[$x]' WHERE id='$ind[$x]'");
	}
}

if(($step == "") && ($search == 1)) {
	header("Location: admin.php?view=admin&ac=memberships&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type");
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" memberships.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total FROM memberships ".iif($conditions,"WHERE $conditions")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="memberships.title";


if($orderby == "memberships.id") {$ordernum=1;}
if($orderby == "memberships.title") {$ordernum=2;}
if($orderby == "memberships.price") {$ordernum=3;}
if($orderby == "memberships.dsub") {$ordernum=4;}
if($orderby == "memberships.time_type") {$ordernum=5;}
if($orderby == "memberships.active") {$ordernum=6;}
if($orderby == "memberships.order") {$ordernum=7;}


	$order[$ordernum]="<img src=\"images/"."$type".".gif\" border=0>";

$sql=$Db1->query("SELECT memberships.* FROM memberships WHERE ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type");
$total_members=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $membership=$Db1->fetch_array($sql); $x++) {
		$sql2=$Db1->query("SELECT username FROM user WHERE membership='$membership[id]'");
		$users=$Db1->num_rows();
		$userslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td>$membership[id]</td>
					<td><a href=\"admin.php?view=admin&ac=edit_membership&id=".$membership[id]."&s=$s&direct=memberships&start=$start&type=$type&orderby=$orderby".iif($search_var,"$search_var")."&".$url_variables."\">".$membership[title]." *</a></td>
					<td>".date('M d', mktime(0,0,$membership[dsub],1,1,1970))."</td>
					<td>$users</td>
					<td>$cursym $membership[price]</td>
					<td>".
								iif($membership[time_type]=="D","Daily").
								iif($membership[time_type]=="W","Weekly").
								iif($membership[time_type]=="M","Monthly").
								iif($membership[time_type]=="Y","Yearly").
								iif($membership[time_type]=="L","Lifetime").
							"</td>
					<td>".iif($membership[active]==1,"Yes","No")."</td>
					<td>".iif($membership[active]==1,"
						<input type=\"hidden\" value=\"$membership[id]\" name=\"ind[$x]\">
						<input type=\"text\" name=\"orders[$x]\" value=\"$membership[order]\" size=2></td>")."
				</tr>
";
	}
}
else {
	$userslisted="
			<tr><td colspan=8>No Memberships Found!</td></tr>
	";
}
	$includes[content].="
<div align=\"center\">

<form action=\"admin.php?view=admin&ac=memberships&action=order&".$url_variables."\" method=\"post\">

<table class=\"tableData\">
	<tr>
		<th><b><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.id&type=$newtype".iif($search_var,"$search_var")."\">Id ".$order[1]."</a></b></th>
		<th><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.title&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Title</b> ".$order[2]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.dsub&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Date</b> ".$order[4]."</a></th>
		<th><b>Users</b></a></th>
		<th><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.price&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Price</b> ".$order[3]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.time_type&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Type</b> ".$order[5]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.active&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Sell?</b> ".$order[6]."</a></th>
		<th><a href=\"admin.php?view=admin&ac=memberships&orderby=memberships.order&type=$newtype&start=$start".iif($search_var,"$search_var")."\"><b>Order</b> ".$order[7]."</a></th>
	</tr>
		$userslisted
</table>

<div align=\"right\"><input type=\"submit\" value=\"Update Order\"></div>
</form>
";


$includes[content].="</div>

<div align=\"center\">
<form action=\"admin.php?view=admin&ac=memberships&action=add&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<b>New Membership</b>
<table class=\"tableBD1\" cellpadding=0 cellspacing=0>
	<tr>
		<td>
<table cellpadding=0 cellspacing=1>
	<tr class=\"tableHL2\">
		<td width=150>Title: ".show_help("What is the name of this membership?")."</td>
		<td><input type=\"text\" name=\"mtitle\"></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Type: ".show_help("How long does each membership unit last?")."</td>
		<td>
		<select name=\"mtype\">
			<option value=\"D\">Day
			<option value=\"W\">Week
			<option value=\"M\" selected=\"selected\">Month
			<option value=\"Y\">Year
			<option value=\"L\">Lifetime
		</select></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Downline Earnings: ".show_help("What % should of referrals earnings should this member type receive?")."</td>
		<td>%<input type=\"text\" name=\"mdle\" value=\"0.05\" size=3></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Price: ".show_help("What is the unit cost for this membership? (per day, week, month, year, or lifetime)")."</td>
		<td>$cursym <input type=\"text\" name=\"mprice\" value=\"\" size=5></td>
	</tr>
	".iif(SETTING_PTP == true,"
	<tr class=\"tableHL2\">
		<td>PTP Amount: ".show_help("How much should this type of member receive for each valid PTP hit?")."</td>
		<td>$cursym <input type=\"text\" name=\"ptp\" value=\"$settings[ptpamount]\" size=6></td>
	</tr>")."
	<tr class=\"tableHL2\">
		<td>Purchase Bonus: ".show_help("This field allows you to reward premium members for when their direct referrals purchase any items. They will be given a % of the purchased price by their referrals.")."</td>
		<td>%<input type=\"text\" name=\"purchase_bonus\" value=\"0\" size=3></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Upgrade Bonus: ".show_help("This field allows you to reward premium members for when their direct referrals upgrade. The value of the bonus is in a % of the upgrade paid price by the referral.")."</td>
		<td>%<input type=\"text\" name=\"upgrade_bonus\" value=\"0\" size=3></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Packages: ".show_help("This field controls the quantity available to purchase at once. 1,2,3 would mean that a member could purchase 1, 2, or 3 units (months) of the membership at once.")."</td>
		<td><input type=\"text\" name=\"mpackages\" value=\"1,2,3,4,5,6,7,8,9,10,11,12\" size=35></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Order: ".show_help("This field controls the order in which the memberships will display. 0 will be displayed above all other numbers.")."</td>
		<td><input type=\"text\" name=\"morder\" value=\"\" size=3></td>
	</tr>
	<tr class=\"tableHL2\">
		<td>Sell? ".show_help("Should this membership be displayed for sale?")."</td>
		<td><input type=\"checkbox\" name=\"mactive\" value=\"1\" checked=\"checked\"></td>
	</tr>
	<tr class=\"tableHL2\">
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Membership\"></td>
	</tr>
</table>
		</td>
	</tr>
</table>
</form>
</div>

";
//**E**//
?>
