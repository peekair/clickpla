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
$includes[title]="Payment Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["mb_refid"]			=	"$mb_refid";
$settings["mb_security"]		=	"$mb_security";
$settings["netpay_security"]	=	"$netpay_security";
$settings["procs_egold"]	 	= 	"$procs_egold";
$settings["procs_evo"]	 	= 	"$procs_evo";
$settings["procs_mb"]		 	= 	"$procs_mb";
$settings["procs_netpay"] 		= 	"$procs_netpay";
$settings["procs_paypal"]	 	= 	"$procs_paypal";
$settings["procs_funds"]	 	= 	"$procs_funds";
$settings["pay_egold"]	 		= 	"$pay_egold";
$settings["pay_mb"]	 			= 	"$pay_mb";
$settings["pay_netpay"] 		= 	"$pay_netpay";
$settings["egold_second"]	 	= 	"$egold_second";
$settings["default_paypal"] 	= 	"$default_paypal";
$settings["pay_paypal"]	 		= 	"$pay_paypal";
$settings["paypal_discount"]	 	= 	"$paypal_discount";
$settings["egold_discount"]	 	= 	"$egold_discount";
$settings["mb_discount"]	 	= 	"$mb_discount";
$settings["account_discount"]	 	= 	"$account_discount";
$settings["netpay_discount"]	 	= 	"$netpay_discount";
$settings["pay_ap"]		 	= 	"$pay_ap";
$settings["procs_ap"]		 	= 	"$procs_ap";
$settings["ap_refid"]		 	= 	"$ap_refid";
$settings["alertpay_code"]	 	= 	"$alertpay_code";
$settings["ap_discount"]	 	= 	"$ap_discount";

$settings["currency"]	 	= 	"$currency";

$settings["mb_currency"]	 	= 	"$mb_currency";
$settings["egold_currency"]	 	= 	"$egold_currency";
$settings["paypal_currency"]	= 	"$paypal_currency";

$settings["order_verification"]	 	= 	"$order_verification";


$settings['liberty_account']	=	$liberty_account;
$settings['liberty_name']	=	$liberty_name;
$settings['liberty_security']	=	$liberty_security;
$settings["procs_liberty"]	 = 	$procs_liberty;
$settings["liberty_currency"]	 = 	$liberty_currency;
$settings["liberty_discount"]	 = 	$liberty_discount;

$settings['procs_perfectm']	 = 	$procs_perfectm;
$settings['perfectm_account']	=	$perfectm_account;
$settings['perfectm_name']	=	$perfectm_name;
$settings['perfectm_security']	=	$perfectm_security;
$settings['perfectm_currency']	 = 	$perfectm_currency;
$settings['perfectm_discount']	 = 	$perfectm_discount;
$settings['perfectm_refid']	 = 	$perfectm_refid;

$settings["procs_routepay"]	 = 	"$procs_routepay";
$settings["routepay_account"]	=	"$routepay_account";
$settings["routepay_name"]	=	"$routepay_name";
$settings["routepay_security"]	=	"$routepay_security";
$settings["routepay_currency"]	 = 	"$routepay_currency";
$settings["routepay_discount"]	 = 	"$routepay_discount";

$settings['procs_okpay']	 = 	$procs_okpay;
$settings['okpay_account']	=	$okpay_account;
$settings['ok_receiver_email']	       =	$ok_receiver_email;
$settings['okpay_security']	=	$okpay_security;
$settings['okpay_currency']	 = 	$okpay_currency;
$settings['okpay_discount']	 = 	$okpay_discount;
$settings['okpay_refid']	 = 	$okpay_refid;




include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=payments&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=payments&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">


	<tr>
		<td width=\"250\"><b>Site Currency: </b></td>
		<td><select name=\"currency\">
            <option value=\"$\" ".iif($settings[currency]=="USD"," selected=\"selected\"").">$ USD
			<option value=\"GBP\" ".iif($settings[currency]=="GBP"," selected=\"selected\"").">&pound; GBP
			<option value=\"EUR\" ".iif($settings[currency]=="EUR"," selected=\"selected\"").">&euro; EUR
		</td>
	</tr>



	<tr>
		<td width=\"250\"><b>First Time Verification: </b><br><small>This option will require all first-time orders to be manually approved.</small></td>
		<td><input type=\"checkbox\" name=\"order_verification\" value=\"1\"".iif($settings[order_verification]==1," Checked=\"Checked\"")."></td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>

	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With Account Funds: </b></td>
		<td><input type=\"checkbox\" name=\"procs_funds\" value=\"1\"".iif($settings[procs_funds]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"account_discount\" value=\"$settings[account_discount]\" size=3>%</td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>


	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With <a href=\"https://www.e-gold.com/newacct/newaccount.asp?cid=619638\" target=\"_blank\">e-Gold</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_egold\" value=\"1\"".iif($settings[procs_egold]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>e-Gold Account: </b></td>
		<td><input type=\"text\" name=\"pay_egold\" value=\"$settings[pay_egold]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Secondary e-Gold Passphrase: </b></td>
		<td><input type=\"text\" name=\"egold_second\" value=\"$settings[egold_second]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"egold_discount\" value=\"$settings[egold_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"egold_currency\">
			<option value=\"1\" ".iif($settings[egold_currency]=="1"," selected=\"selected\"").">\$ USD
			<option value=\44\" ".iif($settings[egold_currency]=="44"," selected=\"selected\"").">&pound; GBP
			<option value=\"85\" ".iif($settings[egold_currency]=="85"," selected=\"selected\"").">&euro; EUR
		</td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>








	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With <a href=\"http://www.libertyreserve.com/?ref=U6488507\" target=\"_blank\">Liberty Reserve</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_liberty\" value=\"1\"".iif($settings[procs_liberty]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Account Number: (example U1234567) </b></td>
		<td><input type=\"text\" name=\"liberty_account\" value=\"$settings[liberty_account]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Account Name: </b></td>
		<td><input type=\"text\" name=\"liberty_name\" value=\"$settings[liberty_name]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Security Key: </b></td>
		<td><input type=\"text\" name=\"liberty_security\" value=\"$settings[liberty_security]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"liberty_discount\" value=\"$settings[liberty_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"liberty_currency\">
			<option value=\"LRUSD\" ".iif($settings[liberty_currency]=="LRUSD"," selected=\"selected\"").">\$ USD
			<option value=\"LREUR\" ".iif($settings[liberty_currency]=="LREUR"," selected=\"selected\"").">&euro; EUR
		</td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>



	<tr>
		<td height=20></td>
	</tr>


	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With <a href=\"https://www.paypal.com/affil/pal=ilwrf_01@hotmail.com\" target=\"_blank\">Paypal</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_paypal\" value=\"1\"".iif($settings[procs_paypal]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Primary Paypal Account: </b><br><small>What is the email address you use to login to paypal with?</small></td>
		<td><input type=\"text\" name=\"default_paypal\" value=\"$settings[default_paypal]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Payment Paypal Account: </b><br><small>What email address would you like payments to be made to (Must be same account as above)</small></td>
		<td><input type=\"text\" name=\"pay_paypal\" value=\"$settings[pay_paypal]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"paypal_discount\" value=\"$settings[paypal_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"paypal_currency\">
			<option value=\"USD\" ".iif($settings[paypal_currency]=="USD"," selected=\"selected\"").">\$ USD
			<option value=\"GBP\" ".iif($settings[paypal_currency]=="GBP"," selected=\"selected\"").">&pound; GBP
			<option value=\"EUR\" ".iif($settings[paypal_currency]=="EUR"," selected=\"selected\"").">&euro; EUR
		</td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>




	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With <a href=\"https://www.alertpay.com/?30504\" target=\"_blank\">AlertPay</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_ap\" value=\"1\"".iif($settings[procs_ap]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Alertpay Account: </b></td>
		<td><input type=\"text\" name=\"pay_ap\" value=\"$settings[pay_ap]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Alertpay IPN Code: </b></td>
		<td><input type=\"text\" name=\"alertpay_code\" value=\"$settings[alertpay_code]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Alertpay Referral Id: </b></td>
		<td><input type=\"text\" name=\"ap_refid\" value=\"$settings[ap_refid]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"ap_discount\" value=\"$settings[ap_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td colspan=2>You must setup the following URL as your <b>IPN Alert URL</b> in your Alertpay settings.<br>
		".$settings[base_url]."/payment.php
		</td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>


	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With <a href=\"http://www.netpay.tv/cgi-bin/newacct.cgi?ref=2153593\">Netpay</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_netpay\" value=\"1\"".iif($settings[procs_netpay]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Netpay Account: </b></td>
		<td><input type=\"text\" name=\"pay_netpay\" value=\"$settings[pay_netpay]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Netpay Security Answer: </b></td>
		<td><input type=\"password\" name=\"netpay_security\" value=\"$settings[netpay_security]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"netpay_discount\" value=\"$settings[netpay_discount]\" size=3>%</td>
	</tr>


	<tr>
		<td height=20></td>
	</tr>


	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Purchase With <a href=\"https://www.moneybookers.com/app/?rid=143863\" target=\"_blank\">Moneybookers</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_mb\" value=\"1\"".iif($settings[procs_mb]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Moneybookers Account: </b></td>
		<td><input type=\"text\" name=\"pay_mb\" value=\"$settings[pay_mb]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Moneybookers Secret Code: </b></td>
		<td><input type=\"password\" name=\"mb_security\" value=\"$settings[mb_security]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Moneybookers Referral Id: </b></td>
		<td><input type=\"text\" name=\"mb_refid\" value=\"$settings[mb_refid]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"mb_discount\" value=\"$settings[mb_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"mb_currency\">
			<option value=\"USD\" ".iif($settings[mb_currency]=="USD"," selected=\"selected\"").">\$ USD
			<option value=\GBP\" ".iif($settings[mb_currency]=="GBP"," selected=\"selected\"").">&pound; GBP
			<option value=\"EUR\" ".iif($settings[mb_currency]=="EUR"," selected=\"selected\"").">&euro; EUR
		</td>
	</tr>


	<tr class=\"tableHL1\">

		<td width=\"250\"><b>Purchase With <a href=\"http://www.perfectmoney.com/?ref=417008\" target=\"_blank\">Perfect Money</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_perfectm\" value=\"1\"".iif($settings[procs_perfectm]==1," Checked=\"Checked\"")."></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Account Number: (example 000001) </b></td>
		<td><input type=\"text\" name=\"perfectm_account\" value=\"$settings[perfectm_account]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Account Name: </b></td>
		<td><input type=\"text\" name=\"perfectm_name\" value=\"$settings[perfectm_name]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Alt pass phrase: </b></td>
		<td><input type=\"text\" name=\"perfectm_security\" value=\"$settings[perfectm_security]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>PerfectMoney Referral Id(Memeber ID): </b></td>
		<td><input type=\"text\" name=\"perfectm_refid\" value=\"$settings[perfectm_refid]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"perfectm_discount\" value=\"$settings[perfectm_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"perfectm_currency\">
			<option value=\"USD\" ".iif($settings[perfectm_currency]=="USD"," selected=\"selected\"").">\$ USD

			<option value=\"EUR\" ".iif($settings[perfectm_currency]=="EUR"," selected=\"selected\"").">&euro; EUR
		</td>
	</tr>
<tr class=\"tableHL1\">

		<td width=\"250\"><b>Purchase With <a href=\"http://www.routepay.com/?ref=RB226784\" target=\"_blank\">RoutePay</a>: </b></td>
		<td><input type=\"checkbox\" name=\"procs_routepay\" value=\"1\"".iif($settings[procs_routepay]==1," Checked=\"Checked\"")."></td>

	</tr>
	<tr>
		<td width=\"250\"><b>Account Number: (example RB000001) </b></td>

		<td><input type=\"text\" name=\"routepay_account\" value=\"$settings[routepay_account]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Account Name: </b></td>

		<td><input type=\"text\" name=\"routepay_name\" value=\"$settings[routepay_name]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Security Key: </b></td>
		<td><input type=\"text\" name=\"routepay_security\" value=\"$settings[routepay_security]\"></td>

	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"routepay_discount\" value=\"$settings[routepay_discount]\" size=3>%</td>

	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"routepay_currency\">

			<option value=\"USD\" ".iif($settings[routepay_currency]=="USD"," selected=\"selected\"").">\$ USD

			<option value=\"EUR\" ".iif($settings[routepay_currency]=="EUR"," selected=\"selected\"").">&euro; EUR

		</td>
	</tr>
<tr class=\"tableHL1\">

		<td width=\"250\"><b>Purchase With <a href=\"http://www.okpay.com/?ref=U6488507\" target=\"_blank\">OkPay</a>: </b></td>

		<td><input type=\"checkbox\" name=\"procs_okpay\" value=\"1\"".iif($settings[procs_okpay]==1," Checked=\"Checked\"")."></td>

	</tr>
	<tr>
		<td width=\"250\"><b>OkPayAccount (example:Email address / Cellphone number or Wallet ID ) </b></td>
		<td><input type=\"text\" name=\"okpay_account\" value=\"$settings[okpay_account]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>OkPay receiver email: </b></td>
		<td><input type=\"text\" name=\"ok_receiver_email\" value=\"$settings[ok_receiver_email]\"></td>
	</tr>
	<tr>

		<td width=\"250\"><b>Okpay Referral Id: </b></td>

		<td><input type=\"text\" name=\"okpay_refid\" value=\"$settings[okpay_refid]\"></td>

	</tr>
	<tr>
		<td width=\"250\"><b>Security Key: </b></td>
		<td><input type=\"text\" name=\"okpay_security\" value=\"$settings[okpay_security]\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Purchase Discount: </b></td>
		<td><input type=\"text\" name=\"okpay_discount\" value=\"$settings[okpay_discount]\" size=3>%</td>
	</tr>
	<tr>
		<td width=\"250\"><b>Currency: </b></td>
		<td><select name=\"okpay_currency\">

			<option value=\"USD\" ".iif($settings[okpay_currency]=="USD"," selected=\"selected\"").">\$ USD

			<option value=\"EUR\" ".iif($settings[okpay_currency]=="EUR"," selected=\"selected\"").">&euro; EUR

		</td>
	</tr>

	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
</form>
";
//**E**//
?>
