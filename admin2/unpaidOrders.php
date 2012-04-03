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
$id = $_REQUEST['id'];
if($id != "") {

	$order = $Db1->query_first("SELECT * FROM orders WHERE order_id='{$id}' and paid=0");
	if(is_array($order)) {
		$Db1->query("INSERT INTO ledger SET
			payment_id='$order[order_id]',
			account='$order[username]',
			product='$order[payment_id]',
			amount='$order[amount]',
			proc='".$procs[$order[proc]]."',
			dsub='".time()."',
			username='$order[username]',
			cost='$order[cost]',
			status='1'
		");
		$sql=$Db1->query("UPDATE orders SET paid='1' WHERE order_id='$id'");
		
		include("wizards/pfunctions.php");
		echo "<p>The order has been completed!</p>";
	}
	else {
		echo "<div class=\"error\">No order could be found with the ID of <b>$id</b></div>";
	}
}

$sql = $Db1->query("SELECT * FROM orders WHERE paid=0 ORDER BY dsub");
while(($row = $Db1->fetch_array($sql))) {
	if($row['cost'] > 0 && $row['payment_id'] != "") {
		$list.="
		<tr>
			<td>{$row['order_id']}</td>
			<td>{$row['username']}</td>
			<td>{$row['payment_id']}</td>
			<td>\${$row['cost']}</td>
			<td>".date("M d, Y",mktime(0,0,$row['dsub'],1,1,1970))."</td>
			<td><a href=\"admin.php?ac=unpaidOrders&action=credit&id={$row['order_id']}&{$url_variables}\" onclick=\"return confirm('Are you sure?')\">Credit</a></td>
		</tr>";
	}
}

?>
<style>

</style>
<p>This tool displays all the temporary orders added to the database. Any orders that are paid for, but do not get automatically processed by IPN will be displayed here for easier order approval.</p>
<br>
<div align="left"><font size="4"><a href="admin.php?view=admin&ac=purgeunproc&".$url_variables.">
Clear Unprocessed Orders</a></div></font>
<br>
<table class="tableData">
	<tr>
		<th>Order ID</th>
		<th>Username</th>
		<th>Product</th>
		<th>Cost</th>
		<th>Date</th>
		<th>Process Order</th>
	</tr>
	<?=$list;?>
</table>


<h3>Process Order ID</h3>
<form action="admin.php?ac=unpaidOrders&action=credit&{$url_variables}" method="POST">
	Order Id: <input type="text" name="id"><br/>
	<input type="submit" value="Process Order">
</form>