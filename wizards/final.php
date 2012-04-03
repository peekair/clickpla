<?
//**S**//
$discount = array(
	1=>$settings[netpay_discount],
	2=>$settings[paypal_discount],
	3=>$settings[egold_discount],
	5=>$settings[account_discount],
	6=>$settings[mb_discount],
	7=>$settings[intgold_discount],
	8=>$settings[ap_discount],
	9=>$settings[liberty_discount],
     	11=>$settings[perfectm_discount],
	12=>$settings[routepay_discount],
	13=>$settings[okpay_discount],
       
);
if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}

function liberty_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
	<form action=\"https://sci.libertyreserve.com\" method=\"get\">
	<input type=\"hidden\" name=\"lr_acc\" value=\"".$settings['liberty_account']."\" />
	<input type=\"hidden\" name=\"lr_store\" value=\"".$settings['liberty_name']."\" />
	<input type=\"hidden\" name=\"lr_amnt\" value=\"$amount\" />
	<input type=\"hidden\" name=\"lr_currency\" value=\"".$settings['liberty_currency']."\" />
	<input type=\"hidden\" name=\"lr_success_url\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\" />
	<input type=\"hidden\" name=\"lr_success_url_method\" value=\"POST\" />
	<input type=\"hidden\" name=\"lr_fail_url\" value=\"".$settings[base_url]."/index.php?".$url_variables."\" />
	<input type=\"hidden\" name=\"lr_fail_url_method\" value=\"LINK\" />
	<input type=\"hidden\" name=\"lr_status_url\" value=\"".$settings[base_url]."/payment.php\" />
	<input type=\"hidden\" name=\"lr_status_url_method\" value=\"POST\" />
	<input type=\"hidden\" name=\"lr_orderid\" value=\"$order_id\" />
	<input type=\"submit\" name=\"submit\" value=\"Pay Now With Liberty Reserve\">
	</form>
";
}




function egold_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
<form action=\"https://www.e-gold.com/sci_asp/payments.asp\" method=\"post\" onSubmit=\"submitonce(this)\">
<input type=\"hidden\" name=\"PAYEE_ACCOUNT\" value=\"$settings[pay_egold]\">
<input type=\"hidden\" name=\"PAYEE_NAME\" value=\"".$settings[site_title]."\">
<input type=hidden name=\"PAYMENT_AMOUNT\" value=\"$amount\">
<input type=hidden name=\"PAYMENT_UNITS\" value=$settings[egold_currency]>
<input type=hidden name=\"PAYMENT_METAL_ID\" value=1>
<input type=hidden name=\"PAYMENT_ID\" value=\"$payment_id\">
<input type=\"hidden\" name=\"STATUS_URL\" value=\"".$settings[base_url]."/payment.php\">
<input type=\"hidden\" name=\"PAYMENT_URL\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\">
<input type=\"hidden\" name=\"PAYMENT_URL_METHOD\" value=\"LINK\">
<input type=\"hidden\" name=\"NOPAYMENT_URL\" value=\"".$settings[base_url]."/index.php?".$url_variables."\">
<input type=\"hidden\" name=\"NOPAYMENT_URL_METHOD\" value=\"LINK\">
<input type=\"hidden\" name=\"BAGGAGE_FIELDS\" value=\"ITEM_ID\">
<input type=\"hidden\" name=\"ITEM_ID\" value=\"$order_id\">
<input type=\"hidden\" name=\"SUGGESTED_MEMO\" value=''>
<input type=\"hidden\" name=\"PAYMENT_METHOD\" value=\"Confirm\">
<input type=\"submit\" name=\"submit\" value=\"Pay Now With E-Gold\">
</form>
	";
}

function intgold_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
<form action=\"https://intgold.com/cgi-bin/webshoppingcart.cgi\" method=\"POST\">
<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
<input type=\"hidden\" name=\"SELLERACCOUNTID\" value=\"".$settings[pay_intgold]."\">
<input type=\"hidden\" name=\"RETURNURL\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\">
<input type=\"hidden\" name=\"CANCEL_RETURN\" value=\"".$settings[base_url]."/index.php?".$url_variables."\">
<input type=\"hidden\" name=\"ITEM_NUMBER\" value=\"$order_id\">
<input type=\"hidden\" name=\"ITEM_NAME\" value=\"$payment_id\">
<input type=\"hidden\" name=\"POSTURL\" value=\"".$settings[base_url]."/payment.php\">
<input type=\"hidden\" name=\"METHOD\" value=\"POST\">
<input type=\"hidden\" name=\"RETURNPAGE\" value=\"HTML\">
<input type=\"hidden\" name=\"AMOUNT\" value=\"$amount\">
<input type=\"submit\" name=\"submit\" value=\"Pay Now With IntGold\">
</form>

	";
}

function netpay_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
<form action=\"https://www.netpay.tv/cgi-bin/merchant/mpay.cgi\" method=\"post\" onSubmit=\"submitonce(this)\">
<input type=\"hidden\" name=\"PAYMENT_AMOUNT\" value=\"$amount\">
<input type=\"hidden\" name=\"PAYEE_NAME\" value=\"$settings[site_title]\">
<input type=\"hidden\" name=\"PAYEE_ACCOUNT\" value=\"$settings[pay_netpay]\">
<input type=\"hidden\" name=\"MEMO\" value=\"$payment_id\">
<input type=\"hidden\" name=\"STATUS_URL\" value=\"".$settings[base_url]."/payment.php\">
<input type=\"hidden\" name=\"RETURN_URL\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\">
<input type=\"hidden\" name=\"CANCEL_URL\" value=\"".$settings[base_url]."/index.php?".$url_variables."\">
<input type=\"hidden\" name=\"PRODUCT_NAME\" value=\"$payment_id\">
<input type=\"hidden\" name=\"EXTRA_INFO\" value=\"$order_id\">
<input type=\"submit\" name=\"submit\" value=\"Pay Now With NetPay\">
</form>
";
}





function ap_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
	<form action='https://www.alertpay.com/PayProcess.aspx' method='post'>
<input type='hidden' name='ap_purchasetype' value='Item'>
<input type='hidden' name='ap_merchant' value='$settings[pay_ap]'>
<input type='hidden'  name='ap_itemname' value='$payment_id'>
<input type='hidden'  name='ap_currency' value='USD'>
<input type='hidden'  name='ap_returnurl' value='".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."'>
<input type='hidden'  name='ap_quantity' value='1'>
<input type='hidden' name='ap_description' value='$payment_id'>
<input type='hidden'  name='ap_amount' value='$amount'>
<input type='hidden'  name='ap_cancelurl' value='".$settings[base_url]."/index.php?".$url_variables."'>
<input type='hidden'  name='apc_1' value='$order_id'>
<input type='hidden'  name='ap_itemcode' value='$order_id'>
<input type=\"submit\" name=\"submit\" value=\"Pay Now With AlertPay\">
</form>


";
}

function fp_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
<FORM action=\"https://www.friendlypay.net/handle.php\" method=\"post\">
	<input type=hidden name=\"receiver\" value=\"$settings[pay_fp]\">
	<input type=hidden name=\"amount\" value=\"$amount\">
	<input type=hidden name=\"item_name\" value=\"$payment_id\">
	<input type=hidden name=\"memo\" value=\"$order_id\">
	<input type=hidden name=\"quantity\" value=\"1\">
	<input type=hidden name=\"return_url\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\">
	<input type=hidden name=\"notify_url\" value=\"".$settings[base_url]."/payment.php\">
	<input type=hidden name=\"cancel_url\" value=\"".$settings[base_url]."/index.php?".$url_variables."\">
	<input type=\"submit\" name=\"submit\" value=\"Pay Now With FriendlyPay\">
</form>
";
}

function mb_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
<form action=\"https://www.moneybookers.com/app/payment.pl\" method=\"post\" target=\"_blank\" onSubmit=\"submitonce(this)\">
<input type=\"hidden\" name=\"pay_to_email\" value=\"$settings[pay_mb]\">
<input type=\"hidden\" name=\"transaction_id\" value=\"$order_id\">
<input type=\"hidden\" name=\"return_url\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\">
<input type=\"hidden\" name=\"cancel_url\" value=\"".$settings[base_url]."/index.php?".$url_variables."\">
<input type=\"hidden\" name=\"status_url\" value=\"".$settings[base_url]."/payment.php\">
<input type=\"hidden\" name=\"language\" value=\"EN\">
<input type=\"hidden\" name=\"merchant_fields\" value=\"customer_id, session_id\">
<input type=\"hidden\" name=\"amount\" value=\"$amount\">
<input type=\"hidden\" name=\"currency\" value=\"$settings[mb_currency]\">
<input type=\"hidden\" name=\"detail1_description\" value=\"Product ID:\">
<input type=\"hidden\" name=\"detail1_text\" value=\"$payment_id\">
<input type=\"hidden\" name=\"confirmation_note\" value=\"Thank You For Your Business!\">
<input type=\"submit\" value=\"Pay Now With Money Bookers\">
</form>
";
}


function paypal_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
<form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" onSubmit=\"submitonce(this)\">
<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
<input type=\"hidden\" name=\"business\" value=\"$settings[pay_paypal]\">
<input type=\"hidden\" name=\"item_name\" value=\"$payment_id\">
<input type=\"hidden\" name=\"item_number\" value=\"$order_id\">
<input type=\"hidden\" name=\"currency_code\" value=\"$settings[paypal_currency]\">

<input type=\"hidden\" name=\"amount\" value=\"$amount\">
<input type=\"hidden\" name=\"return\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\">
<input type=\"hidden\" name=\"cancel_return\" value=\"".$settings[base_url]."/index.php?".$url_variables."\">
<input type=\"hidden\" name=\"notify_url\" value=\"".$settings[base_url]."/payment.php\">
<input type=\"submit\" name=\"submit\" value=\"Pay Now With Paypal\">
</form>";
}


function account_code($payment_id, $cost, $order_id) {
	global $url_variables, $settings;
	return "
<form action=\"index.php?view=account&ac=account_pay&".$url_variables."\" method=\"post\" onSubmit=\"submitonce(this)\">
<input type=\"hidden\" name=\"order_id\" value=\"$order_id\">
<input type=\"submit\" name=\"submit\" value=\"Pay Now With Your Account Funds\">
</form>";
}


function perfectm_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
	<form action=\"https://perfectmoney.com/api/step1.asp\" method=\"post\">
	<input type=\"hidden\" name=\"PAYEE_ACCOUNT\" value=\"".$settings['perfectm_account']."\" />
	<input type=\"hidden\" name=\"PAYEE_NAME\" value=\"".$settings['perfectm_name']."\" />
	<input type=\"hidden\" name=\"PAYMENT_AMOUNT\" value=\"$amount\" />
	<input type=\"hidden\" name=\"PAYMENT_UNITS\" value=\"".$settings['perfectm_currency']."\" />
	<input type=\"hidden\" name=\"PAYMENT_URL\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\" />
	<input type=\"hidden\" name=\"PAYMENT_URL_METHOD\" value=\"POST\" />
	<input type=\"hidden\" name=\"NOPAYMENT_URL\" value=\"".$settings[base_url]."/index.php?".$url_variables."\" />
	<input type=\"hidden\" name=\"NOPAYMENT_URL_METHOD\" value=\"LINK\" />
	<input type=\"hidden\" name=\"STATUS_URL\" value=\"".$settings[base_url]."/payment.php\" />
	<input type=\"hidden\" name=\"status_url_method\" value=\"POST\" />
	<input type=\"hidden\" name=\"PAYMENT_ID\" value=\"$order_id\" />
	<input type=\"submit\" name=\"submit\" value=\"Pay With PerfectMoney\">
	</form>
";
}

function routepay_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
	<form action=\"https://www.routepay.com/sci.asp\" method=\"post\">
	<input type=\"hidden\" name=\"rp_acc_merchant\" value=\"".$settings['routepay_account']."\" />
	<input type=\"hidden\" name=\"rp_amount\" value=\"$amount\" />
	<input type=\"hidden\" name=\"rp_currency\" value=\"".$settings['routepay_currency']."\" />
	<input type=\"hidden\" name=\"rp_payment_url\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\" />
	<input type=\"hidden\" name=\"rp_nopayment_url\" value=\"".$settings[base_url]."/index.php?".$url_variables."\" />
	<input type=\"hidden\" name=\"rp_ipn_url\" value=\"".$settings[base_url]."/payment.php\" />
	<input type=\"hidden\" name=\"rp_memo\" value=\"$payment_id\" />
	<input type=\"hidden\" name=\"rp_merchant_ref\" value=\"$order_id\" />
	<input type=\"submit\" name=\"submit\" value=\"Pay With RoutePay\">
	</form>
";
}

function okpay_code($payment_id, $amount, $order_id) {
	global $url_variables, $settings;
	return "
	<form action=\"https://www.okpay.com/process.html\" method=\"post\">
	<input type=\"hidden\" name=\"ok_receiver\" value=\"".$settings['okpay_account']."\" />
	<input type=\"hidden\" name=\"ok_fees\" value=\"1\" />
	<input type=\"hidden\" name=\"ok_item_1_price\" value=\"$amount\" />
	<input type=hidden name=\"ok_item_1_name\" value=\"$payment_id\">
	<input type=\"hidden\" name=\"ok_invoice\" value=\"$order_id\" />
	<input type=\"hidden\" name=\"ok_currency\" value=\"".$settings['okpay_currency']."\" />
	<input type=\"hidden\" name=\"ok_return_success\" value=\"".$settings[base_url]."/index.php?view=thankyou&order_id=$order_id&".$url_variables."\" />
	<input type=\"hidden\" name=\"ok_return_fail\" value=\"".$settings[base_url]."/index.php?".$url_variables."\" />
	<input type=\"hidden\" name=\"ok_ipn\" value=\"".$settings[base_url]."/payment.php\" />
	<input type=\"submit\" name=\"submit\" value=\"Pay Now With OkPay\">
	</form>
";
}
foreach ($procs as $key => $value) {
	$proclisting.="<option value=\"$key\">$value".iif($discount[$key] > 0," (".$discount[$key]."% Discount)")."\n";
}

$amount=floor($amount);
if($amount < 0) {
	$amount=0;
}

$cost=0;

switch($order[ad_type]) {
######################################################################################################################################################
	case "link":
		$sql=$Db1->query("SELECT * FROM ads WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		if(($thisad['class']=="P") && ($thisad[credits] >= 1)) {
			$Db1->sql_close();
			header("Location: index.php?view=account&ac=add_credits_link&id=$thisad[id]&".$url_variables);
		}

		$cost1=$settings['class_'.strtolower($cclass).'_ratio'] * $amount * ($settings[base_price]/1000) +
			iif($bgcolor!='',$settings[link_hl_price],0) +
			iif($subtitle!='',$settings[subtitleCost],0) +
			iif($icon!='',$settings[iconCost],0)
		;
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee];
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];

$cost = number_format($cost ,2);


		$payment_id="Link Ad Hits";
		$productdisplay="
		<tr>
			<td>Link Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Link Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		";
		$theextrafields="
			<tr>
				<td>Link Value: </td>
				<td>
					".iif($thisad[credits] == 0,"
					<input type=\"hidden\" name=\"newclass\" value=\"true\">
					<select name=\"cclass\" onchange=\"calculate()\">
						<option value=\"A\">Class A - $settings[class_a_time] Seconds
						<option value=\"B\">Class B - $settings[class_b_time] Seconds
						<option value=\"C\">Class C - $settings[class_c_time] Seconds
						<option value=\"D\" selected=\"selected\">Class D - $settings[class_d_time] Seconds
					</select>
					","
						<input type=\"hidden\" name=\"cclass\" value=\"".$thisad['class']."\">
						Class ".$thisad['class']." - $thisad[timed] Seconds
					")."
				</td>
			</tr>
		".iif($settings['subtitleOn']==1 && $thisad['subtitle_on'] != 1,"
			<tr>
				<td>Subtitle: </td>
				<td><input type=\"checkbox\" name=\"subtitle\" value=\"1\" onchange=\"calculate()\"> $cursym ".$settings[subtitleCost]." **</td>
			</tr>
		")."
		".iif($settings['iconOn']==1 && $thisad['icon_on'] != 1,"
			<tr>
				<td>Icon: </td>
				<td><input type=\"checkbox\" name=\"icon\" value=\"1\" onchange=\"calculate()\"> $cursym".$settings[iconCost]." **</td>
			</tr>
		")."
		".iif(($settings['iconOn']==1 && $thisad['icon_on'] != 1) || ($settings['subtitleOn']==1 && $thisad['subtitle_on'] != 1),"
			<tr>
				<td colspan=2><small>**Configurable from ad manager after purchase</small></td>
			</tr>
		")."
			<tr>
				<td>Highlight Color: </td>
				<td>
					".iif($thisad[credits] == 0,"
					<select name=\"bgcolor\" onchange=\"calculate()\">
						<option value=\"\">None
					<option value=\"turquoise\" style=\"background-color: turquoise\">Turquoise +$cursym $settings[link_hl_price]
					<option value=\"Yellow\" style=\"background-color: yellow\">Yellow +$cursym $settings[link_hl_price]
					<option value=\"Pink\" style=\"background-color: pink\">Pink +$cursym $settings[link_hl_price]
					</select>
					","
						<input type=\"hidden\" name=\"bgcolor\" value=\"".$thisad['bgcolor']."\">
						".iif($thisad['bgcolor']!="","<div style=\"background-color: $thisad[bgcolor]\">$thisad[bgcolor]</div>","None")."
					")."
				</td>
			</tr>
		";
	break;
######################################################################################################################################################
	case "ptra":
		$sql=$Db1->query("SELECT * FROM ptrads WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		if(($thisad['class']=="P") && ($thisad[credits] >= 1)) {
			$Db1->sql_close();
			header("Location: index.php?view=account&ac=add_credits_ptrad&id=$thisad[id]&".$url_variables);
		}

		$cost1=$settings['ptr_'.strtolower($cclass).'_ratio'] * $amount * ($settings[base_price]/1000) +
			iif($bgcolor!='',$settings[link_hl_price],0) +
			iif($subtitle!='',$settings[subtitleCost],0) +
			iif($icon!='',$settings[iconCost],0);
          $cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		  $cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee];
$cost = number_format($cost ,2);

		$payment_id="Paid To Read Hits";
		$productdisplay="
		<tr>
			<td>Title:</td>
			<td>".stripslashes($thisad[title])."</td>
		</tr>
		<tr>
			<td>Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		";
		$theextrafields="
			<tr>
				<td>Ad Value: </td>
				<td>
					".iif($thisad[credits] == 0,"
					<input type=\"hidden\" name=\"newclass\" value=\"true\">
					<select name=\"cclass\" onchange=\"calculate()\">
						<option value=\"A\">Class A - $settings[ptr_a_time] Seconds
						<option value=\"B\">Class B - $settings[ptr_b_time] Seconds
						<option value=\"C\">Class C - $settings[ptr_c_time] Seconds
						<option value=\"D\" selected=\"selected\">Class D - $settings[ptr_d_time] Seconds
					</select>
					","
						<input type=\"hidden\" name=\"cclass\" value=\"".$thisad['class']."\">
						Class ".$thisad['class']." - $thisad[timed] Seconds
					")."
				</td>
			</tr>
			<tr>
				<td>Highlight Color: </td>
				<td>
					".iif($thisad[credits] == 0,"
					<select name=\"bgcolor\" onchange=\"calculate()\">
						<option value=\"\">None
					<option value=\"turquoise\" style=\"background-color: turquoise\">Turquoise +$cursym $settings[link_hl_price]
					<option value=\"Yellow\" style=\"background-color: yellow\">Yellow +$cursym $settings[link_hl_price]
					<option value=\"Pink\" style=\"background-color: pink\">Pink +$cursym $settings[link_hl_price]
					</select>
					","
						<input type=\"hidden\" name=\"bgcolor\" value=\"".$thisad['bgcolor']."\">
						".iif($thisad['bgcolor']!="","<div style=\"background-color: $thisad[bgcolor]\">$thisad[bgcolor]</div>","None")."
					")."
				</td>
			</tr>
		".iif($settings['subtitleOn']==1 && $thisad['subtitle_on'] != 1,"
			<tr>
				<td>Subtitle: </td>
				<td><input type=\"checkbox\" name=\"subtitle\" value=\"1\" onchange=\"calculate()\"> $cursym".$settings[subtitleCost]." **</td>
			</tr>
		")."
		".iif($settings['iconOn']==1 && $thisad['icon_on'] != 1,"
			<tr>
				<td>Icon: </td>
				<td><input type=\"checkbox\" name=\"icon\" value=\"1\" onchange=\"calculate()\"> $cursym".$settings[iconCost]." **</td>
			</tr>
		")."
		".iif(($settings['iconOn']==1 && $thisad['icon_on'] != 1) || ($settings['subtitleOn']==1 && $thisad['subtitle_on'] != 1),"
			<tr>
				<td colspan=2><small>**Configurable from ad manager after purchase</small></td>
			</tr>
		")."
		";
	break;
######################################################################################################################################################
	case "linkc":
		$cost1=$settings['class_d_ratio'] * $amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee];
$cost = number_format($cost ,2);

		$payment_id="Link Credits";
	break;
######################################################################################################################################################
	case "ptrac":
		$cost1=$settings['ptr_d_ratio'] * $amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee];
$cost = number_format($cost ,2);

		$payment_id="PTR Credits";
	break;
######################################################################################################################################################
	case "bannerc":
		$cost1=($amount/$settings[banner_ratio]) * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Banner Credits";
	break;
######################################################################################################################################################
	case "fbannerc":
		$cost1=($amount/$settings[fbanner_ratio]) * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Featured Banner Credits";
	break;
######################################################################################################################################################
	case "fadc":
		$cost1=($amount/$settings[fad_ratio]) * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Featured Ad Credits";
	break;
######################################################################################################################################################
	case "popupsc":
		if(SETTING_PTP != true) {
			haultscript();
		}
		$cost1=$settings['popup_ratio'] * $amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Popup Credits";
	break;
######################################################################################################################################################
	case "ptrc":
		if(SETTING_PTR != true) {
			haultscript();
		}
		$cost1=$settings['ptr_ratio'] * $amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Paid Email Credits";
	break;
######################################################################################################################################################
	case "popups":
		if(SETTING_PTP != true) {
			haultscript();
		}
		$sql=$Db1->query("SELECT * FROM popups WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);


		$cost1=$settings['popup_ratio'] * $amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="PTP Hits";
		$productdisplay="
		<tr>
			<td>Link Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Link Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		";
	break;
######################################################################################################################################################
	case "ptsu":
		if(SETTING_PTSU != true) {
			haultscript();
		}
		$sql=$Db1->query("SELECT * FROM ptsuads WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);


		$cost1=$settings['ptsu_cost'] * $amount +
			iif($subtitle!='',$settings[subtitleCost],0) +
			iif($icon!='',$settings[iconCost],0);
			$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
			$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Guaranteed Signups";
		$productdisplay="
		<tr>
			<td>Signup Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Target URL:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		".iif($settings['subtitleOn']==1 && $thisad['subtitle_on'] != 1,"
			<tr>
				<td>Subtitle: </td>
				<td><input type=\"checkbox\" name=\"subtitle\" value=\"1\" onchange=\"calculate()\"> $cursym".$settings[subtitleCost]." **</td>
			</tr>
		")."
		".iif($settings['iconOn']==1 && $thisad['icon_on'] != 1,"
			<tr>
				<td>Icon: </td>
				<td><input type=\"checkbox\" name=\"icon\" value=\"1\" onchange=\"calculate()\"> $cursym".$settings[iconCost]." **</td>
			</tr>
		")."
		".iif(($settings['iconOn']==1 && $thisad['icon_on'] != 1) || ($settings['subtitleOn']==1 && $thisad['subtitle_on'] != 1),"
			<tr>
				<td colspan=2><small>**Configurable from ad manager after purchase</small></td>
			</tr>
		")."
		";
	break;
######################################################################################################################################################
	case "ptsuc":
		$cost1=$settings['ptsu_cost'] * $amount ;
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Guaranteed Signup Credits";
	break;
######################################################################################################################################################
	case "banner":
		$sql=$Db1->query("SELECT * FROM banners WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		$cost1=($amount/$settings[banner_ratio]) * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Banner Impressions";
		$productdisplay="
		<tr>
			<td colspan=2 align=\"center\"><a href=\"$thisad[target]\" target=\"_blank\"><img src=\"$thisad[banner]\" border=0></a></td>
		</tr>
		<tr>
			<td>Banner Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Ad Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		";
	break;
######################################################################################################################################################
	case "fbanner":
		$sql=$Db1->query("SELECT * FROM fbanners WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		$cost1=($amount/$settings[fbanner_ratio]) * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Featured Banner Impressions";
		$productdisplay="
		<tr>
			<td colspan=2 align=\"center\"><a href=\"$thisad[target]\" target=\"_blank\"><img src=\"$thisad[banner]\" border=0></a></td>
		</tr>
		<tr>
			<td>Banner Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Ad Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		";
	break;
######################################################################################################################################################
	case "fad":
		$sql=$Db1->query("SELECT * FROM fads WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		$cost1=($amount/$settings[fad_ratio]) * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Featured Ad Impressions";
		$productdisplay="
		<tr>
			<td>Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		<tr>
			<td>Featured Ad:</td>
			<td><textarea cols=20 rows=4 disabled=\"disabled\">$thisad[description]</textarea></td>
		</tr>
		";
	break;
######################################################################################################################################################
	case "ptr":
		$sql=$Db1->query("SELECT * FROM emails WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		$cost1=$settings['ptr_ratio'] * $amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Paid Email Hits";
		$productdisplay="
		<tr>
			<td>Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>
		<tr>
			<td>Featured Ad:</td>
			<td><textarea cols=20 rows=4>$thisad[description]</textarea><br /><small>(changes here will not be saved)</small></td>
		</tr>
		";
	break;
######################################################################################################################################################
	case "flink":
		$sql=$Db1->query("SELECT * FROM flinks WHERE id='$order[ad_id]'");
		$thisad=$Db1->fetch_array($sql);

		$cost1=($amount) * $settings[flink_cost];
		
		if($bgcolor != "") $cost1+=$settings[flink_hl_price];
		if($marq == 1) $cost1+=$settings[flink_marquee_price];
		
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Featured Link Rotation";
		$productdisplay="
		<tr>
			<td>Title:</td>
			<td>$thisad[title]</td>
		</tr>
		<tr>
			<td>Target:</td>
			<td><a href=\"$thisad[target]\" target=\"_blank\">$thisad[target]</a></td>
		</tr>";
		$theextrafields="
		<tr>
			<td>Highlight Color: </td>
			<td>
				".iif($thisad[dend] <= time(),"
				<select name=\"bgcolor\" onchange=\"calculate()\">
					<option value=\"\">None
					<option value=\"turquoise\" style=\"background-color: turquoise\">Turquoise +$cursym $settings[flink_hl_price]
					<option value=\"Yellow\" style=\"background-color: yellow\">Yellow +$cursym $settings[flink_hl_price]
					<option value=\"Pink\" style=\"background-color: pink\">Pink +$cursym $settings[flink_hl_price]
				</select>
				","
					<input type=\"hidden\" name=\"bgcolor\" value=\"".$thisad['bgcolor']."\">
					".iif($thisad['bgcolor']!="","<div style=\"background-color: $thisad[bgcolor]\">$thisad[bgcolor]</div>","None")."
				")."
			</td>
		</tr>
		<tr>
			<td><marquee>Marquee Scroll?</marquee></td>
			<td>
				".iif($thisad[dend] <= time(),"
				<select name=\"marq\" onchange=\"calculate()\">
					<option value=\"\">No
					<option value=\"1\">Yes +$cursym $settings[flink_marquee_price]
				</select>
				","
					<input type=\"hidden\" name=\"marq\" value=\"".$thisad['marquee']."\">
					".iif($thisad['marquee']==1,"Yes","No")."
				")."
			</td>
		</tr>
		";
	break;
######################################################################################################################################################
	case "upgrade":
		$sql=$Db1->query("SELECT * FROM memberships WHERE id='$order[premium_id]'");
		$membership=$Db1->fetch_array($sql);
		$packages[upgrade]=explode(",",$membership[packages]);

		$cost1=$amount * $membership[price];
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="$membership[title] Membership";
	break;
######################################################################################################################################################
	case "special":
		$sql=$Db1->query("SELECT * FROM specials WHERE id='$order[special_id]'");
		$special=$Db1->fetch_array($sql);
		$packages[upgrade]=explode(",",$special[packages]);

		$cost1=$amount * $special[price];
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; 
		$cost = round($cost ,2); 
		$cost1 = round($cost1 ,2);
		$cost3 = round($cost3 ,2);
		
		$payment_id="$special[title]";
	break;
######################################################################################################################################################
	case "credits":
		$cost1=$amount * ($settings[base_price]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Raw Credits";
	break;
######################################################################################################################################################
	case "xcredits":
		$cost1=$amount * ($settings[base_price]*$settings[x_ratio]/1000);
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="X-Credits";
	break;
######################################################################################################################################################
	case "referrals":
		$cost1=$amount * $settings[referral_price];
		$cost=($cost1 * $settings[buy_percent]) + $cost1 + $settings[buy_fee];
		$cost3=($cost1 * $settings[buy_percent]) + $settings[buy_fee]; $cost = number_format($cost ,2); 
		$payment_id="Referrals";
	break;
######################################################################################################################################################
}

$cost = doubleval($cost);

if(!check_valid_price($cost)) {
	$cost="$cost"."0";
}

if(($step == 4) && ($submited == 1)) {
	if(($cost <= 0) || ($amount < 1)) {
		$Db1->sql_close();
		header("Location: index.php?view=prices&".$url_variables."");
		exit;
	}
	else {
		if($discount[$proc] > 0) {
			$cost=$cost-($cost*$discount[$proc]/100);
			$cost = round($cost ,2); 
			
		}
		
		if($newclass==true) {
			if($order[ad_type] == "link") {
				$pamount = $settings['class_'.strtolower($cclass).'_earn'];
				$timer = $settings['class_'.strtolower($cclass).'_time'];
			}
			if($order[ad_type] == "ptra") {
				$pamount = $settings['ptr_'.strtolower($cclass).'_earn'];
				$timer = $settings['ptr_'.strtolower($cclass).'_time'];
			}
		}
		
//			points='$points',
		$sql=$Db1->query("UPDATE orders SET
			cost='$cost',
			payment_id='$payment_id ($amount".iif($order[ad_type]=="flink"," Month").iif($order[ad_type]=="upgrade"," ".
									iif($membership[time_type]=="D","Day").
									iif($membership[time_type]=="W","Week").
									iif($membership[time_type]=="M","Month").
									iif($membership[time_type]=="Y","Year").
									iif($membership[time_type]=="L","Lifetime").
							"").")',
			amount='".addslashes($amount)."',

			subtitle='".addslashes($subtitle)."',
			icon='".addslashes($icon)."',

			".iif($newclass==true,
					"class='".addslashes($cclass)."', pamount='".$pamount."', timed='".$timer."', ",
				"class='$thisad[class]', pamount='$thisad[pamount]', timed='$thisad[timed]', "
			)."
			".iif($thisad[credits] <= 0, "bgcolor='$bgcolor', marquee='".addslashes($marq)."',")."
				proc='".addslashes($proc)."'
		WHERE order_id='$order[order_id]'
		");


		$sql=$Db1->query("SELECT * FROM orders WHERE order_id='$pid'");
		$order=$Db1->fetch_array($sql);
		$order[payment_id]=$order[payment_id]." ($settings[site_title])";
      
		switch($proc) {
			case 1:
				$return = netpay_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 2:
				$return = paypal_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 3:
				$return = egold_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 5:
				$return = account_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 6:
				$return = mb_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 7:
				$return = intgold_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 8:
				$return = ap_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 9:
				$return = liberty_code($order[payment_id], $cost, $order[order_id]);
			break;

                 	case 11:
				$return = perfectm_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 12:
				$return = routepay_code($order[payment_id], $cost, $order[order_id]);
			break;
			case 13:
				$return = okpay_code($order[payment_id], $cost, $order[order_id]);
			break;
                 
		}
		
		$includes[content]="<br />
		<div align=\"center\">
		<table>
			<tr>
				<td><b>Product:</b> </td>
				<td>&nbsp;$order[payment_id]</td>
			</tr>
			<tr>
				<td><b>Price:</b> </td>
				<td>$cursym ".number_format($cost1,2)." </td>
			</tr>
			<tr>
				<td><b>Fees:</b> </td>
				<td>$cursym ".number_format($cost3,2)." </td>
			</tr>
			
			
			<tr>
				<td><b>Total:</b> </td>
				<td>$cursym ".number_format($cost,2)." </td>
			</tr>
			<tr>
				<td colspan=2 align=\"center\">$return</td>
			</tr>
		</table>
		</div>";
	}
}
else {
	$sql=$Db1->query("SELECT userid FROM user WHERE refered='' and username!='$username' ORDER BY rand()");
	$totalrefsavailable=$Db1->num_rows();
	$includes[content]="
<div align=\"center\">
<script>
var pointprice = ".($settings[base_price]/1000).";
".iif($settings[premium_cost]!="","var premiumprice = ".$settings[premium_cost].";")."


".iif($settings[referral_price]!="","var refprice = ".$settings[referral_price].";")."
".iif($settings[ptsu_cost]!="","var ptsuprice = ".$settings[ptsu_cost].";")."

".iif($settings[class_a_ratio]!="","var class_a_ratio = ".$settings[class_a_ratio].";")."
".iif($settings[class_b_ratio]!="","var class_b_ratio = ".$settings[class_b_ratio].";")."
".iif($settings[class_c_ratio]!="","var class_c_ratio = ".$settings[class_c_ratio].";")."
".iif($settings[class_d_ratio]!="","var class_d_ratio = ".$settings[class_d_ratio].";")."

".iif($settings[iconCost]!="","var icon_cost = ".$settings[iconCost].";")."
".iif($settings[subtitleCost]!="","var subtitle_cost = ".$settings[subtitleCost].";")."


".iif($settings[ptr_a_ratio]!="","var ptr_a_ratio = ".$settings[ptr_a_ratio].";")."
".iif($settings[ptr_b_ratio]!="","var ptr_b_ratio = ".$settings[ptr_b_ratio].";")."
".iif($settings[ptr_c_ratio]!="","var ptr_c_ratio = ".$settings[ptr_c_ratio].";")."
".iif($settings[ptr_d_ratio]!="","var ptr_d_ratio = ".$settings[ptr_d_ratio].";")."

".iif($settings[x_ratio]!="","var xratio = ".$settings[x_ratio].";")."


".iif($settings[link_hl_price]!="","var linkhlfee = ".$settings[link_hl_price].";")."
".iif($settings[flink_hl_price]!="","var flinkhlfee = ".$settings[flink_hl_price].";")."
".iif($settings[flink_marquee_price]!="","var flinkmfee = ".$settings[flink_marquee_price].";")."

".iif($order[ad_type]=="upgrade","upgradeprice=".$membership[price].";")."
".iif($order[ad_type]=="special","specialprice=".$special[price].";")."

".iif($settings[sellpopups] == 1, "var popupratio = ".$settings[popup_ratio].";")."
".iif($settings[sellptr] == 1, "var ptrratio = ".$settings[ptr_ratio].";")."

".iif($settings[fad_ratio]!="","var fadratio = ".$settings[fad_ratio].";")."
".iif($settings[banner_ratio]!="","var bannerratio = ".$settings[banner_ratio].";")."


".iif($settings[fbanner_ratio]!="","var fbannerratio = ".$settings[fbanner_ratio].";")."
".iif($settings[flink_cost]!="","var flinkcost = ".$settings[flink_cost].";")."

var buyfee = ".iif($settings[buy_fee]=="",0,$settings[buy_fee]).";
var currency = \"$cursym \";
</script>
<script src=\"wizards/$order[ad_type].js\"></script>
<form name=\"form\" action=\"index.php?view=account&ac=buywizard&step=4&pid=$order[order_id]&".$url_variables."\" method=\"post\">
<input type=\"hidden\" name=\"submited\" value=\"1\">
	<table>
		$productdisplay
		<tr>
			<td width=\"75\">Product: </td>
			<td>$payment_id</td>
		</tr>
		<tr>
			<td>Amount:</td>
			<td>
			<select name=\"amount\" onchange=\"calculate()\">";

			for($x=0; $x<count($packages[$order[ad_type]]); $x++) {
				if(($order[ad_type] != "referrals") || ($totalrefsavailable >= $packages[$order[ad_type]][$x])) {
					$includes[content].="<option value=\"".$packages[$order[ad_type]][$x]."\"".iif($samount==$packages[$order[ad_type]][$x], " selected=\"selected\"").">".$packages[$order[ad_type]][$x]." ".iif($order[ad_type] == "flink","Month Rotation").iif($order[ad_type]=="upgrade"," ".
								iif($membership[time_type]=="D","Day").
								iif($membership[time_type]=="W","Week").
								iif($membership[time_type]=="M","Month").
								iif($membership[time_type]=="Y","Year").
								iif($membership[time_type]=="L","Lifetime").
							" Membership")."</option>";
				}
			}

			$includes[content].="
			</select>
			</td>
		</tr>
		$theextrafields
		<tr>
			<td>Price: $cursym </td>
			<td><input type=\"text\" name=\"price\" onkeyup=\"calculate()\" size=6></td>
		</tr>
		<tr>
			<td valign=\"top\">Payment Method: </td>
			<td>
				<select name=\"proc\">
					$proclisting
				</select><br /><sup>*All Methods Are Instant!</sup>
			</td>
		</tr>
		<tr>
			<td align=\"center\" colspan=2><input type=\"submit\" value=\"Next Step =>\"></td>
		</tr>
	</table>
</form>
</div>
<script>
	calculate();
</script>
";
}
$producttitle=$payment_id;
//**E**//
?>