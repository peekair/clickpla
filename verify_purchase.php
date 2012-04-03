<?
$includes[title]="Verify Purchase";


if(($action == "verify") && ($order_id != "")) {
	$sql=$Db1->query("SELECT * FROM ledger WHERE payment_id='$order_id'");
	if($Db1->num_rows() != 0) {
		$user=$Db1->fetch_array($sql);
		$sql=$Db1->query("UPDATE ledger SET email_verify='1' WHERE payment_id='$order_id'");
		$includes[content]="Thank you for verifying the purchase. The order still must be manually verified by us, however it will take less time.";
	}
	else {
		$includes[content]="<b style=\"color:red\">error.</b>";
	}
}


?>