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
$includes[title]="Add Credits To Link Ad";
//**VS**//$setting[ptc]//**VE**//
//**S**//
$sql=$Db1->query("SELECT * FROM ads WHERE id='$id'");
$thisad=$Db1->fetch_array($sql);

$c2add=floor($c2add);

if($cclass == "P") $cclass="D";
if($cclass == -1) {
	$cclass=$thisad['class'];
}

if(!is_numeric($c2add)) {
	$c2add=0;
}

if($action == "add") {
	$Db1->query("INSERT INTO logs SET username='".$username."', log='Added PTC Credits; Class: $cclass; Credits: $c2add', dsub='".time()."'");
	if(
		($cclass != "A") &&
		($cclass != "B") &&
		($cclass != "C") &&
		($cclass != "D") 
//		&& ($cclass != "P")
	) {
		$cclass='D';
//		mail("admin@illusive-web.com","Soc Cheater!","Username: $username","From: admin@illusive-web.com");
	}
	if($c2add < 1) {
		$error_msg="You must enter at least 1 credit!";
	}
	else if(($c2add*$settings['class_'.strtolower($cclass).'_credit_ratio']) > $thismemberinfo[link_credits]) {
		$error_msg="You do not have sufficient credits on your account! ";
	}
	else {
		$sql=$Db1->query("UPDATE ads SET credits=credits+$c2add".iif($newclass=true,", class='$cclass', pamount='".$settings['class_'.strtolower($cclass).'_earn']."', timed='".$settings['class_'.strtolower($cclass).'_time']."'")."  WHERE id='$id'");
		$sql=$Db1->query("UPDATE user SET link_credits=link_credits-".($c2add*$settings['class_'.strtolower($cclass).'_credit_ratio'])." WHERE username='$username'");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=myads&adtype=link&".$url_variables."");
	}
}


if(($step == 0) && (($thisad['class'] != "P") || ($thisad[credits] <= 0))) {
	$includes[content]="
	<br />
<div align=\"center\">
<form action=\"index.php?view=account&ac=add_credits_link&step=2&".$url_variables."\" method=\"post\">
<input type=\"hidden\" value=\"$id\" name=\"id\">
<table>
	<tr>
		<td>
			How do you wish to fund the credits?<br />
			<input type=\"radio\" name=\"addoption\" value=\"account\" id=\"account\"".iif($thismemberinfo[link_credits]>=1," Checked=\"checked\"")."> <label for=\"account\">Account Link Credits ($thismemberinfo[link_credits])</label><br />
			<input type=\"radio\" name=\"addoption\" value=\"purchase\" id=\"purchase\"".iif($thismemberinfo[link_credits]<1," Checked=\"checked\"")."> <label for=\"purchase\">Purchase Credits</label>
		</td>
	</tr>
	<tr>
		<td align=\"right\"><input type=\"submit\" value=\"Next =>\"></td>
	</tr>
</table>
</form>
</div>
";
}
else if(($step == 2) && (($thisad['class'] != "P") || ($thisad[credits] <= 0))) {
	if($addoption == "purchase") {
		while(!isset($pid)) { //make sure a unique order_id gets generated!
			$temppid=rand_string(10);
			$Db1->query("SELECT order_id FROM orders WHERE order_id='$temppid'");
			if($Db1->num_rows() == 0) {
				$pid = $temppid;
			}
		}
		$sql=$Db1->query("INSERT INTO orders SET
			order_id='$pid',
			username='$username',
			ad_type='link',
			ad_id='$id',
			dsub='".time()."'
		");
		$Db1->sql_close();
		header("Location: index.php?view=account&ac=buywizard&step=3&pid=$pid&".$url_variables."");
	}
	else if($addoption == "account") {
		$includes[content]="
<div align=\"center\">
".iif($error_msg,"<script>alert('$error_msg');</script>")."
<form name=\"form\" action=\"index.php?view=account&ac=add_credits_link&id=$id&step=2&addoption=account&action=add&".$url_variables."\" method=\"post\" onsubmit=\"submitonce(this)\">
<table>
	<tr>
		<td width=120>Ad: </td>
		<td>$thisad[title]</td>
	</tr>
	<tr>
		<td>Credits To Add: </td>
		<td><input type=\"text\" name=\"c2add\" value=\"0\" size=\"10\" onkeyup=\"calculate()\"></td>
	</tr>
	<tr>
		<td>Hit Value: </td>
		<td>
			".iif($thisad[credits] == 0,"
			<input type=\"hidden\" name=\"newclass\" value=\"true\">
			<select name=\"cclass\" onchange=\"calculate2()\">
				<option value=\"A\">Class A - $settings[class_a_time] Seconds
				<option value=\"B\">Class B - $settings[class_b_time] Seconds
				<option value=\"C\">Class C - $settings[class_c_time] Seconds
				<option value=\"D\" selected=\"selected\">Class D - $settings[class_d_time] Seconds
			</select>
			","
				<input type=\"hidden\" name=\"cclass\" value=\"-1\">
				Class ".$thisad['class']." - $thisad[timed] Seconds
			")."
		</td>
	</tr>
		<tr>
			<td>Cost: </td>
			<td><input type=\"text\" name=\"price\" value=\"$thismemberinfo[link_credits]\" onkeyup=\"calculate2()\" size=\"6\"> Credits</td>
		</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Credits\"></td>
	</tr>
</table>
<small>
You Have $thismemberinfo[link_credits] Credits On Your Account<br />

</small>
</div>
<script>
function calculate() {
	linkratio=0
	switch(document.form.cclass.value) {
		case 'A':
			linkratio=$settings[class_a_credit_ratio]
		break;
		case 'B':
			linkratio=$settings[class_b_credit_ratio]
		break;
		case 'C':
			linkratio=$settings[class_c_credit_ratio]
		break;
		case 'D':
			linkratio=$settings[class_d_credit_ratio]
		break;
	}
	document.form.price.value= (document.form.c2add.value * linkratio)
}
function calculate2() {
	linkratio=0
	switch(document.form.cclass.value) {
		case 'A':
			linkratio=$settings[class_a_credit_ratio]
		break;
		case 'B':
			linkratio=$settings[class_b_credit_ratio]
		break;
		case 'C':
			linkratio=$settings[class_c_credit_ratio]
		break;
		case 'D':
			linkratio=$settings[class_d_credit_ratio]
		break;
	}
	document.form.c2add.value= (document.form.price.value / linkratio)
}
calculate2()
</script>
";
		
	}
}
else {
	$includes[content]="Because this is a point link, you cannot add any credits to it until its current credits have been depleted.";
}
//**E**//

?>