<?
//**S**//
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
  $value = urlencode(stripslashes($value));
  $req .= "&$key=$value";
}
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= 'Content-Length: ' . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('www.paypal.com', 80, $errno, $errstr, 30);
$receiver_email = $_POST['receiver_email'];
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$invoice = $_POST['invoice'];
$option_selection1 = $_POST['option_selection1'];
$option_selection2 = $_POST['option_selection2'];
$payment_status = $_POST['payment_status'];
$pending_reason = $_POST['pending_reason'];
$payment_date = $_POST['payment_date'];
$payment_gross = $_POST['payment_gross'];
$payment_fee = $_POST['payment_fee'];
$txn_id = $_POST['txn_id'];
$txn_type = $_POST['txn_type'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address_street = $_POST['address_street'];
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_zip = $_POST['address_zip'];
$address_country = $_POST['address_country'];
$address_status = $_POST['address_status'];
$payer_email = $_POST['payer_email'];
$payer_id = $_POST['payer_id'];
$payer_status = $_POST['payer_status'];
$payment_type = $_POST['payment_type'];
$verify_sign = $_POST['verify_sign'];

$xtra[name]=$first_name." ".$last_name;
$xtra[transaction_id]=$txn_id;
$xtra[account]=$payer_email;


if (!$fp) {
  // ERROR
  echo "$errstr ($errno)";
} else {
  fputs ($fp, $header . $req);
  while (!feof($fp)) {
    $res = fgets ($fp, 1024);
    if (strcmp ($res, "VERIFIED") == 0) {$result="VERIFIED";}
      else if (strcmp ($res, "INVALID") == 0) { $result="INVALID";}
  }
  fclose ($fp);
}

if($result == "VERIFIED") {
	if($payment_status == "Completed") {
		if($payment_gross == $order['cost']) {
			$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$txn_id'");
			if($Db1->num_rows() == 0) {
				if(
					($receiver_email == $settings[default_paypal]) ||
					($receiver_email == $settings[pay_paypal])
				  )
				{
					$VERIFIED=true;
				}
			}
		}
	}
}
//**E**//
?>
