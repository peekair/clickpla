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
$includes[title]="View Order Stats";

$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$id'");
$order=$Db1->fetch_array($sql);

if($Db1->num_rows() == 0) {
	$includes[content]="No orders with the id $id";
}
else {
	$includes[content]="
<table>
	
	".iif($order[order_id],"
		<tr>
			<td>Id: </td>
			<td>$order[order_id]</td>
		</tr>
	")."
	
	".iif($order[proc],"
		<tr>
			<td>Payment Method: </td>
			<td>".($procs[$order[proc]])."</td>
		</tr>
	")."
	
	".iif($order[payment_id],"
		<tr>
			<td>Payment Id: </td>
			<td>$order[payment_id]</td>
		</tr>
	")."
	
	".iif($order[amount],"
		<tr>
			<td>Amount: </td>
			<td>$order[amount]</td>
		</tr>
	")."
	
	".iif($order[dsub],"
		<tr>
			<td>Date: </td>
			<td>".date('g:i M d, Y', mktime(0,0,$order[dsub],1,1,1970))."</td>
		</tr>
	")."
	
	".iif($order[username],"
		<tr>
			<td>Username: </td>
			<td>$order[username]</td>
		</tr>
	")."
	
	".iif($order[ad_type],"
		<tr>
			<td>Ad Type: </td>
			<td>$order[ad_type]</td>
		</tr>
	")."
	
	".iif($order[cost],"
		<tr>
			<td>Cost: </td>
			<td>$order[cost]</td>
		</tr>
	")."
	
	".iif($order[ad_id],"
		<tr>
			<td>Ad ID: </td>
			<td>$order[ad_id]</td>
		</tr>
	")."
	
	".iif($order[points],"
		<tr>
			<td>Points: </td>
			<td>$order[points]</td>
		</tr>
	")."
	
	".iif($order['class'],"
		<tr>
			<td>Class: </td>
			<td>$order[class]</td>
		</tr>
	")."
	
	".iif($order[timed],"
		<tr>
			<td>Time: </td>
			<td>$order[timed]</td>
		</tr>
	")."
	
	".iif($order[pamount],"
		<tr>
			<td>Ad Value: </td>
			<td>$order[pamount]</td>
		</tr>
	")."
	
	".iif($order[premium_id],"
		<tr>
			<td>Premium Type: </td>
			<td>$order[premium_id]</td>
		</tr>
	")."
	
</table>
	";
}

?>