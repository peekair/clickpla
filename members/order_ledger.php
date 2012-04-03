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
$includes[title]="Order Ledger";
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
if(($step == "") && ($search == 1)) {
	header("Location: index.php?view=account&ac=order_ledger&search=1&search_str=$search_str&search_by=$search_by&step=2&orderby=$orderby&type=$type&".$url_variables);
	exit;
}

if($search == 1) {
	$search_str2=explode(" ", $search_str);
	for($x=0; $x<count($search_str2); $x++) {
		$conditions.=" ledger.$search_by LIKE '%$search_str2[$x]%' ";
		if($x < (count($search_str2)-1)) {
			$conditions .= " AND ";
		}
	}
	$search_var="&search=1&step=2&search_str=$search_str&search_by=$search_by";
}


$sql=$Db1->query("SELECT COUNT(id) AS total  FROM ledger WHERE username='$username' AND ".iif($conditions,"$conditions","1")."");
$thet=$Db1->fetch_array($sql);
$ttotal=$thet[total];

if($start == "") {$start=0;}
$end=$start+25;
if($start+25 > $ttotal) {$end=$ttotal;}


if($type == "") 	$type="DESC";
if($type == "DESC") $newtype="ASC";
if($type == "ASC") 	$newtype="DESC";

if($orderby == "") 	$orderby="ledger.dsub";
$order[$orderby]="<img src=\"images/"."$type".".gif\" border=0>";



$sql=$Db1->query("SELECT ledger.* FROM ledger WHERE username='$username' AND ".iif($conditions,"$conditions","1")." ORDER BY $orderby $type LIMIT $start, 25");
$total_ledger=$Db1->num_rows();
if($Db1->num_rows() != 0) {
	for($x=0; $this_ledger=$Db1->fetch_array($sql); $x++) {
		$ledgerslisted .= "
				<tr class=\"tableHL2\" onmouseover=\"this.className='tableHL3'\" onmouseout=\"this.className='tableHL2'\">
					<td NOWRAP=\"NOWRAP\">".date('m/d/y', mktime(0,0,$this_ledger[dsub],1,1,1970))."</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[account]</td>
					<td NOWRAP=\"NOWRAP\">$this_ledger[product]</td>
					<td NOWRAP=\"NOWRAP\">$cursym$this_ledger[cost]</td>
					<td NOWRAP=\"NOWRAP\">".
						iif($this_ledger[status]=="0","Pending").
						iif($this_ledger[status]=="1","Completed").
						iif($this_ledger[status]=="2","Denied").
					"</td>
				</tr>
";
	}
}
else {
	$ledgerslisted="
		<tr>
			<td class=\"tableHL2\" colspan=10 align=\"center\">No Orders Found!</td>
		</tr>";
}

	$includes[content].="
<div align=\"center\">


<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"100%\">
	<tr>
		<td>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td NOWRAP><a href=\"index.php?view=account&ac=order_ledger&orderby=ledger.dsub&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Date</b> ".$order['ledger.dsub']."</a></td>
					<td NOWRAP><a href=\"index.php?view=account&ac=order_ledger&orderby=ledger.account&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Account</b> ".$order['ledger.account']."</a></td>
					<td NOWRAP><a href=\"index.php?view=account&ac=order_ledger&orderby=ledger.product&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Product</b> ".$order['ledger.product']."</a></td>
					<td NOWRAP><a href=\"index.php?view=account&ac=order_ledger&orderby=ledger.cost&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Price</b> ".$order['ledger.cost']."</a></td>
					<td NOWRAP><a href=\"index.php?view=account&ac=order_ledger&orderby=ledger.status&type=$newtype&start=$start".iif($search_var,"$search_var")."&".$url_variables."\"><b>Status</b> ".$order['ledger.status']."</a></td>
				</tr>
				
					$ledgerslisted
				
			</table>
		</td>
	</tr>
</table>
";
if($ttotal > 0) {
	$bc.=($start+1)." Through ".$end." Of $ttotal $tut_type Orders<br />";
	if($ttotal > 25) {$bc.="[ ";}
	if($start > 9) {
		$bstart=$start-25;
		$bc.="<a href=\"index.php?view=account&ac=order_ledger&start=$bstart&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Back</a>";
	}
	if(($start > 9) && ($start+25 < $ttotal)) {$bc.=" :: ";}
	if($start+25 < $ttotal) {
		$start=$start+25;
		$bc.=" <a href=\"index.php?view=account&ac=order_ledger&start=$start&orderby=$orderby&step=2&type=$type".iif($search_var,"$search_var")."&".$url_variables."\">Next</a> ";
	}
	if($ttotal > 25) {$bc.=" ]";}
}



$includes[content].=$bc."</div><br />
If you have made a purchase that is not listed, please contact us and be sure to include the payment transaction ID for verification.
";
//**E**//
?>
