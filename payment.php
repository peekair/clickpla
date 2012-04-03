<?
include("includes/functions.php");
$vip=getenv("REMOTE_ADDR");

$complete_sale=0;

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
if($_POST['txn_id'] != "") { // Paypal
	$order_id=$_POST['item_number'];
}
else if($_POST['ITEM_ID'] != "") { // E-Gold
	$order_id=$_POST['ITEM_ID'];
}
else if($_POST['EXTRA_INFO'] != "") { // Netpay
	$order_id=$_POST['EXTRA_INFO'];
}
else if($_POST['transaction_ref'] != "") { // StormPay
	$order_id=$_POST['transaction_ref'];
}
else if($_POST['transaction_id'] != "") { // MoneyBookers
	$order_id=$_POST['transaction_id'];
}
else if($_POST['ITEM_NUMBER'] != "") { // IntGold
	$order_id=$_POST['ITEM_NUMBER'];
}
else if($_POST['ap_itemcode'] != "") { // Alertpay
	$order_id=$_POST['ap_itemcode'];
}
else if($_REQUEST['lr_orderid'] != "") { // Liberty Reserve
	$order_id=$_REQUEST['lr_orderid'];
}
else if($_REQUEST['PAYMENT_ID'] != "") { // perfectmoney

	$order_id=$_REQUEST['PAYMENT_ID'];
}
else if($_REQUEST['rp_merchant_ref'] != "") { // routepay

	$order_id=$_REQUEST['rp_merchant_ref'];
}
else if($_REQUEST['ok_invoice'] != "") { // okpay

	$order_id=$_REQUEST['ok_invoice'];
}





$VERIFIED=false;


include("config.php");
include("includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);

include("includes/globals.php");

$today_date=date("d/m/y");
$sql=$Db1->query("SELECT id FROM stats WHERE date='$today_date'");
if($Db1->num_rows() == 0) {
	$sql-$Db1->query("INSERT INTO stats SET date='$today_date'");
}



$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$order_id' and paid='0' ORDER BY dsub DESC LIMIT 1");
if($Db1->num_rows() != 0) {
	$order=$Db1->fetch_array($sql);
	switch($order[proc]) {
		case 1: include("verify/netpay.php");
		break;
		case 2: include("verify/paypal.php");
		break;
		case 3: include("verify/egold.php");
		break;
		case 4: include("verify/stormpay.php");
		break;
		case 6: include("verify/mb.php");
		break;
		case 7: include("verify/intgold.php");
		break;
		case 8: include("verify/alertpay.php");
		break;
		case 9: include("verify/liberty.php");
		break; 
                       case 11: include("verify/perfectmoney.php");
		break;
                case 12: include("verify/routepay.php");
		break;
                case 13: include("verify/okpay.php");
		break;
               
	}

//	$sql=$Db1->query("SELECT * FROM payment_block WHERE account=''");
//	if($Db1->num_rows() != 0) {


	if($VERIFIED == true) {

		$sql=$Db1->query("SELECT * FROM ledger WHERE transaction_id='$xtra[transaction_id]'");
		if($Db1->num_rows > 0) {
			$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='This processer payment ID already used! ($xtra[account]) ($cursym $order[cost])', dsub='".time()."'");
			$Db1->sql_close();
			exit;
		}

		if($order[cost] == 0 || $order[payment_id] == "" || $order[amount] == 0 || $order[proc] == 0) {
			$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Possible Purchase Cheat Attempt ($xtra[account]) ($cursym $order[cost])', dsub='".time()."'");
			$Db1->sql_close();
			exit;
		}




		$Db1->query("INSERT INTO ledger SET
			payment_id='$order[order_id]',
			transaction_id='$xtra[transaction_id]',
			account='$xtra[account]',
			name='$xtra[name]',
			product='$order[payment_id]',
			amount='$order[amount]',
			proc='".$procs[$order[proc]]."',
			dsub='".time()."',
			username='$order[username]',
			cost='$order[cost]'
		");
		$sql=$Db1->query("UPDATE orders SET paid='1' WHERE order_id='$order_id'");

		$sql=$Db1->query("SELECT type, email FROM user WHERE username='$order[username]'");
		$userinfo=$Db1->fetch_array($sql);

		$complete_sale=0;
		if($settings[order_verification] == 1) {
//			$sql=$Db1->query("INSERT INTO logs SET log='Debug 1 : ', dsub='".time()."'");
			$sql=$Db1->query("SELECT * FROM payment_approve WHERE account='$xtra[account]'");
			if($Db1->num_rows() == 0) {
//			$sql=$Db1->query("INSERT INTO logs SET log='Debug 2', dsub='".time()."'");
				if(Verify_Email_Address($xtra[account]) == true) {$to=$xtra[account];}
				else {$to=$userinfo[email];}
//				$sql=$Db1->query("INSERT INTO logs SET log='Debug 3', dsub='".time()."'");
				send_mail($to,"","Please confirm your purchase at $settings[site_title]","
	Hello,
	A purchase has been made at $settings[site_title] with payment from the account: $xtra[account].
	Before the purchase can be completed, we must manually approve this transaction. Please help us speed up this process by verifying the purchase below.


	Order Information
	Product ID: $order[payment_id]
	Cost: $cursym  $order[cost]
	Username: $order[username]
	Ip Address: $vip


	If you made this purchase, please goto the following URL in your browser:
	$settings[base_url]/index.php?view=verify_purchase&order_id=$order[order_id]&action=verify

	If you did not make this purchase, please contact us right away.


	-$settings[domain_name] Admin
	$settings[base_url]
	");

				$Db1->sql_close();
				$complete_sale=0;
				exit;
			}
			else {
				$complete_sale=1;
			}
		}

		if(is_account_blocked($xtra[account]) > 0) {
			$sql=$Db1->query("UPDATE orders SET status='2' WHERE order_id='$order_id'");
			$sql=$Db1->query("INSERT INTO logs SET username='".$order[username]."', order_id='".$order[order_id]."', log='Attempted to make payment with a blocked account ($xtra[account]) ($cursym $order[cost])', dsub='".time()."'");
			$Db1->sql_close();
			$complete_sale=0;
			exit;
		}
		else {
			$complete_sale=1;
		}


		if($complete_sale == 1) {
			$sql=$Db1->query("UPDATE ledger SET status='1' WHERE payment_id='$order_id'");
			$sql=$Db1->query("UPDATE stats SET income=income+".$order['cost']." WHERE date='$today_date'");

			if($settings[tickets_buy] > 0) {
				$Db1->query("UPDATE user SET tickets=tickets+$settings[tickets_buy] WHERE username='$order[username]'");
			}
			if($settings[purchcon_buy] > 0) {
				$Db1->query("UPDATE user SET purchcon_tic=purchcon_tic+$settings[purchcon_buy] WHERE username='$order[username]'");
			}

			$sql=$Db1->query("SELECT type FROM user WHERE username='$order[username]'");
			$userinfo=$Db1->fetch_array($sql);

			$sql=$Db1->query("SELECT refered FROM user WHERE username='$order[username]'");
			$referedinfo=$Db1->fetch_array($sql);


			if((isset($referedinfo[refered])) && ($referedinfo[refered] != $order[username])) {
				$sql=$Db1->query("SELECT type, membership FROM user WHERE username='$referedinfo[refered]'");
				$referrerinfo=$Db1->fetch_array($sql);
				if($referrerinfo[type] == 1) {
					$sql=$Db1->query("SELECT * FROM memberships WHERE id='".$referrerinfo[membership]."'");
					$membershipinfo=$Db1->fetch_array($sql);
					$refearnamount=$membershipinfo[purchase_bonus]*$order[cost]/100;
					$Db1->query("UPDATE user SET upline_earnings=upline_earnings+$refearnamount WHERE username='$order[username]' ");
					$Db1->query("UPDATE user SET balance=balance+$refearnamount, referral_earns=referral_earns+$refearnamount WHERE username='$referedinfo[refered]'");
					$Db1->query("INSERT INTO logs SET username='".$referedinfo[refered]."', order_id='".$order[order_id]."', log='Received $cursym $refearnamount Bonus For Referral Purchase', dsub='".time()."'");
				}
			}
			include("wizards/pfunctions.php");
		}
	}
}
$Db1->sql_close();
exit;

//**E**//
?>
