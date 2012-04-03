<?
$includes[title]="Proof Of Payments";
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
$lpp=200;

if($order == "") $order = "DESC";
//if($order == "DESC") $nextOrder="ASC"; else $nextOrder="DESC";
if($sort == "") $sort="dsub";

//if($sort == "amount" ) $order="ASC"; else $order="DESC";


function paginateListing($pageDisp, $lpp) {
	global $Db1, $sort, $order, $url_variables;
	$sql=$Db1->query("SELECT COUNT(id) as total FROM payment_history WHERE status=1");
	$temp=$Db1->fetch_array($sql);
	$count=$temp[total];
	$return .= "<div class=\"paginationHead\">Viewing ".((($pageDisp-1)*$lpp)+1)." through ".((($pageDisp-1)*$lpp)+$lpp)." of $count payments</div>";
	$tp = ceil($count/$lpp);
	for($x=0; $x<$tp; $x++) {
		if($pageDisp == ($x+1)) $incst="paginationSelected";
		else $incst="";
		$return.="<div class=\"pagination ".$incst."\"><a href=\"index.php?view=proof&p=".($x)."&sort=$sort&order=$order&".$url_variables."\">".($x+1)."</a></div>";
	}
	return $return;
}

$p = $_GET['p'];
if($p=="") $p=0;
if($p!=0)	$startFrom=($p*$lpp).", ";



?>


<?
$sql = $Db1->query("SELECT * FROM payment_history WHERE status=1 ORDER BY $sort $order LIMIT $startFrom $lpp ");
$showing = $Db1->num_rows();
if($showing == 0) {
?>
<p>We are a brand new program and so no payments have been made yet, but you could be one of the first!</p>
<?
} else { ?>


<style>
.pagination {
	float: left;
	padding: 10px 3px;
}
</style>


<table class="proof" style="width:100%;" cellpadding="0" cellspacing="0">
	<tr>
		<th><b>ID #</b></th>
		
		<?
		if($order == "ASC") {
		?>
		<th><b><a href="index.php?view=proof&sort=username&order=DESC&".$url_variables."">User</a></b></th>
		<?
		} else {
		?>
		<th><b><a href="index.php?view=proof&sort=username&order=ASC&".$url_variables."">User</a></b></th>
		<?
		}
		?>
		
		
		
		<th><b>Method</b></th>
		<?
		if($order == "ASC") {
		?>
		<th><b><a href="index.php?view=proof&sort=amount&order=DESC&".$url_variables."">Amount</a></b></th>
		<?
		} else {
		?>
		<th><b><a href="index.php?view=proof&sort=amount&order=ASC&".$url_variables."">Amount</a></b></th>
		<?
		}
		?>
		
		
		<?
		if($order == "ASC") {
		?>
<th><b><a href="index.php?view=proof&sort=rdsub&order=DESC&".$url_variables."">Date Requested</a></b></th>
		<?
		} else {
		?>
<th><b><a href="index.php?view=proof&sort=rdsub&order=ASC&".$url_variables."">Date Requested</a></b></th>
		<?
		}
		?>
		
		<?
		if($order == "ASC") {
		?>
		<th><b><a href="index.php?view=proof&sort=paid&order=DESC&".$url_variables."">Date Paid</a></b></th>
		<?
		} else {
		?>
		<th><b><a href="index.php?view=proof&sort=paid&order=ASC&".$url_variables."">Date Paid</a></b></th>
		<?
		}
		?>
		

	</tr>


<? 
while($row = $Db1->fetch_array($sql)) {
	echo "<tr>
		<td>".$row['id']."</td>
		<td>".$row['username']."</td>
		<td>".$row['accounttype']."</td>
		<td>$cursym".$row['amount']."</td>
		<td>".date("M/d/Y",mktime(0,0,$row['rdsub'],1,1,1970))."</td>
		<td>".date("M/d/Y",mktime(0,0,$row['dsub'],1,1,1970))."</td>
	</tr>";
}
?>

</table>
<? echo paginateListing($p+1, $lpp); ?>
<br/>
<? } ?>