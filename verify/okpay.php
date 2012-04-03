<?

global $settings;


$req = 'ok_verify=true';
foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";  
} 

$header .= "POST /ipn-verify.html HTTP/1.0\r\n"; 
$header .= "Host: www.okpay.com\r\n"; 
$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n"; 
$fp = fsockopen ('www.okpay.com', 80, $errno, $errstr, 30); 
 

$RECEIVER_EMAIL         =$_POST['ok_receiver_email'];
$PAYEE_ACCOUNT		=$_POST['ok_receiver'];
$PAYMENT_CURRENCY	=$_POST['ok_txn_currency'];
$PAYMENT_GROSS		=$_POST['ok_txn_gross'];
$PAYMENT_NET		=$_POST['ok_txn_net'];
$PAYMENT_FEE		=$_POST['ok_txn_fee'];

$ok_txn_id	   =     $_POST['ok_txn_id'];
$PAYMENT_STATUS    =     $_POST['ok_txn_status'];

$PAYER_ACCOUNT	   =     $_POST['ok_payer_email'];
$PAYER_UID	   =     $_POST['ok_payer_id'];

$xtra[name]=$PAYER_UID;
$xtra[transaction_id]=$ok_txn_id;
$xtra[account]=$PAYER_ACCOUNT;



if (!$fp) 
{
  echo "$errstr ($errno)";
} else
{
  // NO HTTP ERROR  
  fputs ($fp, $header . $req); 
  while (!feof($fp))
  { 
    $res = fgets ($fp, 1024); 
    if (strcmp ($res, "VERIFIED") == 0){$result="VERIFIED";}

      else if (strcmp ($res, "INVALID") == 0) { $result="INVALID";}

  }
  fclose ($fp); 
}

if($result == "VERIFIED") {

	if($PAYMENT_STATUS == "completed") {

		if($PAYMENT_NET == $order['cost']) {


			$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$ok_txn_id'");

			if($Db1->num_rows() == 0) {

				if(

					($RECEIVER_EMAIL == $settings[ok_receiver_email])

				  )

				{

					$VERIFIED=true;

				}

			}

		}

	}

}

?>