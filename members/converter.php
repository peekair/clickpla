<?
$includes[title]="Converter";
//**S**//

function getratio($type) {
	global $settings;
	if($type == "points") {
		$rato = $settings[point_convert_ratio];
		$field="points";
	}
	if($type == "balance") {
		$rato = $settings[balance_convert_ratio];
		$field="balance";
	}
	if($type == "link") {
		$rato = $settings[link_convert_ratio];
		$field="link_credits";
	}
	if($type == "ptra") {
		$rato = $settings[ptra_convert_ratio];
		$field="ptra_credits";
	}
	if($type == "email") {
		$rato = $settings[email_convert_ratio];
		$field="ptr_credits";
	}
	if($type == "popup") {
		$rato = $settings[popup_convert_ratio];
		$field="popup_credits";
	}
	if($type == "banner") {
		$rato = $settings[banner_convert_ratio];
		$field="banner_credits";
	}
	if($type == "fbanner") {
		$rato = $settings[fbanner_convert_ratio];
		$field="fbanner_credits";
	}
	if($type == "fad") {
		$rato = $settings[fad_convert_ratio];
		$field="fad_credits";
	}
	return array($rato, $field);
}


if(($action == "convert") && ($submitted == 1)) {
//	if($cfrom == "points") {exit;}
	$validcto = array("points"=>1,"balance"=>1,"link"=>1,"ptra"=>1,"email"=>1,"popup"=>1,"banner"=>1,"fbanner"=>1,"fad"=>1);

	if(!isset($validcto[$cto])) {
		$Db1->query("INSERT INTO logs SET username='".$username."', log='Possible Converter Cheat Attempt: $amountfrom $cfrom to $amountto $cto', dsub='".time()."'");
		$Db1->sql_close();
		echo "<strong>Hault!</strong><br/>Details of your attempt have been logged in case of foul play! If you feel this warning has been reached by error, please contact us.";
		exit;
	}

	switch ($cfrom) {
	case "balance":
		$amountfrom=(floor($amountfrom*100000))/100000;
	    break;
	case "points":
		$amountfrom=floor($amountfrom);
	    break;
	default:
		$Db1->query("INSERT INTO logs SET username='".$username."', log='Possible Converter Cheat Attempt: $amountfrom $cfrom to $amountto $cto', dsub='".time()."'");
		$Db1->sql_close();
		echo "<strong>Hault!</strong><br/>Details of your attempt have been logged in case of foul play! If you feel this warning has been reached by error, please contact us.";
		exit;
	}

	if(($cfrom != "points") && ($cfrom != "balance") && ($cfrom != "gpoints")) {
		$Db1->query("INSERT INTO logs SET username='".$username."', log='Possible Converter Cheat Attempt: $amountfrom $cfrom to $amountto $cto', dsub='".time()."'");
		$amountfrom = 0;
		$amountto = 0;
		$error="Cheat Attempt!";
	}
	else if(($amountfrom <= 0.00001) || ($amountto <= 0.00001) || (($amountfrom < 1) && ($cfrom != "balance"))) {
		$Db1->query("INSERT INTO logs SET username='".$username."', log='Converter Error: $amountfrom $cfrom to $amountto $cto', dsub='".time()."'");
		$amountfrom = 0;
		$amountto = 0;
		$error="The numbers you have entered are invalid!";
	}
	else {
		$to=getratio($cto);
		$from=getratio($cfrom);
		$amount=$amountfrom;
		$newamount=(floor($to[0] * $amount / $from[0]*100000)/100000);
		if($thismemberinfo[$from[1]] >= $amount) {
			$Db1->query("UPDATE user SET $from[1]=$from[1]-$amount, $to[1]=$to[1]+$newamount WHERE username='$username'");
			$Db1->query("INSERT INTO logs SET username='".$username."', log='Converted $amount $cfrom to $newamount $cto', dsub='".time()."'");
			$Db1->sql_close();
			header("Location: index.php?view=account&ac=converter&".$url_variables."");
		}
		else {
			$error="You do not have efficient balance on your account to complete this conversion!";
		}
	}
}
//**E**//

$includes[content]="
<div align=\"center\">
<script>
var	lastchange=1;


function getratio(type) {
	".iif((($settings[point_convert_ratio]!=0) && ($settings[balance] == 1)),"if(type == \"points\") {
		return ".$settings[point_convert_ratio].";
	}")."
	".iif((($settings[balance_convert_ratio]!=0) && ($settings[points] == 1)),"if(type == \"balance\") {
		return ".$settings[balance_convert_ratio].";
	}")."
	".iif((($settings[link_convert_ratio]!=0) && (SETTING_PTC == true)),"if(type == \"link\") {
		return ".$settings[link_convert_ratio].";
	}")."
	".iif((($settings[email_convert_ratio]!=0) && (SETTING_PTR == true)),"if(type == \"email\") {
		return ".$settings[email_convert_ratio].";
	}")."
	".iif((($settings[ptra_convert_ratio]!=0) && (SETTING_PTRA == true)),"if(type == \"ptra\") {
		return ".$settings[ptra_convert_ratio].";
	}")."
	".iif((($settings[popup_convert_ratio]!=0) && (SETTING_PTP == true)),"if(type == \"popup\") {
		return ".$settings[popup_convert_ratio].";
	}")."
	".iif($settings[banner_convert_ratio]!=0,"if(type == \"banner\") {
		return ".$settings[banner_convert_ratio].";
	}")."
	".iif($settings[fbanner_convert_ratio]!=0,"if(type == \"fbanner\") {
		return ".$settings[fbanner_convert_ratio].";
	}")."
	".iif($settings[fad_convert_ratio]!=0,"if(type == \"fad\") {
		return ".$settings[fad_convert_ratio].";
	}")."
}

function newcat() {
	if(lastchange == 1) {
		calculatefrom();
	}
	else {
		calculateto();
	}
}

function floorit(sub) {
/*	if((document.form.cto.value == 'gpoints') || (document.form.cto.value == 'gcredits') || (document.form.cto.value == 'link') || (document.form.cto.value == 'email') || (document.form.cto.value == 'popup') || (document.form.cto.value == 'banner') || (document.form.cto.value == 'fbanner') || (document.form.cto.value == 'fad')) {
		document.form.amountto.value=Math.floor(document.form.amountto.value);
	}
	else {
		document.form.amountto.value=Math.round(document.form.amountto.value*100000)/100000;
	}
	document.form.amountfrom.value=Math.round(document.form.amountfrom.value*100000)/100000;
*/
}

function calculatefrom() {
	lastchange=1;
	document.form.amountto.value = getratio(document.form.cto.value) * document.form.amountfrom.value / getratio(document.form.cfrom.value);
	floorit();
}


function calculateto() {
	lastchange=2;
	document.form.amountfrom.value = getratio(document.form.cfrom.value) * document.form.amountto.value / getratio(document.form.cto.value);
	floorit();
}

balance = new Array;

balance['points']=".$thismemberinfo[points].";
balance['balance']=".$thismemberinfo[balance].";

function verify(form) {
	if(balance[form.cfrom.value] < form.amountfrom.value) {
		alert('Your account does not have sufficient balances to complete this transfer.');
		return false;
	}
	if((form.amountfrom.value<=0) || (form.amountto.value<=0)) {
		alert('Both amounts must be greater than 0!');
		return false;
	}
	if((form.amountfrom.value<1) && (form.cfrom.value != 'balance')) {
		alert('You cannot convert from less than 1 point!');
		return false;
	}
	else {
		return true;
	}
}

".iif($error!="","alert('$error');")."

</script>
<form action=\"index.php?view=account&ac=converter&action=convert&".$url_variables."\" method=\"post\" name=\"form\" onsubmit=\"return verify(this)\">
<input type=\"hidden\" value=\"1\" name=\"submitted\">
<table>
	<tr>
		<td colspan=2>
		Convert
			<select name=\"cfrom\" onchange=\"newcat()\">
				".iif($settings[point_convert_ratio]!=0,"<option value=\"points\">Points")."
				".iif($settings[balance_convert_ratio]!=0,"<option value=\"balance\">Cash")."
			</select>
			To
			<select name=\"cto\" onchange=\"newcat()\">
				".iif($settings[point_convert_ratio]!=0 && $settings[points] == 1,"<option value=\"points\">Points")."
				".iif($settings[balance_convert_ratio]!=0 && $settings[balance] == 1,"<option value=\"balance\">Cash")."
				".iif($settings[link_convert_ratio]!=0 && SETTING_PTC == true,"<option value=\"link\">Link Credits")."
				".iif($settings[email_convert_ratio]!=0 && SETTING_PTR == true,"<option value=\"email\">Email Credits")."
				".iif($settings[ptra_convert_ratio]!=0 && SETTING_PTRA == true,"<option value=\"ptra\">PTR Credits")."
				".iif($settings[popup_convert_ratio]!=0 && SETTING_PTP == true,"<option value=\"popup\">Popup Credits")."
				".iif($settings[banner_convert_ratio]!=0,"<option value=\"banner\">Banner Credits")."
				".iif($settings[fbanner_convert_ratio]!=0,"<option value=\"fbanner\">Featured Banner Credits")."
				".iif($settings[fad_convert_ratio]!=0,"<option value=\"fad\">Featured Ad Credits")."
			</select>
		</td>
	</tr>
	<tr>
		<td align=\"center\">Amount: <input type=\"text\" size=10 name=\"amountfrom\" value=\"0\" onkeyup=\"calculatefrom()\" style=\"text-align: center\"></td>
		<td align=\"center\">Amount: <input type=\"text\" size=10 name=\"amountto\" value=\"0\" onkeyup=\"calculateto()\" style=\"text-align: center\"></td>
	</tr>
	<tr>
		<td align=\"center\" colspan=2><input type=\"submit\" value=\"Convert Now\"></td>
	</tr>
</table>
</form>
</div>
";



?>