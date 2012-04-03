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
$includes[title]="Credit Accounts";

if($action == "credit") {
	for($x=0; $x<count($memberIndex); $x++) {
		if($selected[$x] == 1) {
			$sql=$Db1->query("SELECT ptp_temp FROM user WHERE userid='".$memberIndex[$x]."'");
			$temp=$Db1->fetch_array($sql);
//			echo "".$memberIndex[$x]." : $".($temp[ptp_temp]*0.0002)."<br>";
			$Db1->query("UPDATE user SET balance=balance+".($temp[ptp_temp]*0.0002)." WHERE userid='".$memberIndex[$x]."'");
		}
	}
	$Db1->query("UPDATE user SET ptp_temp=0");
}

$sql=$Db1->query("SELECT * FROM user WHERE ptp_temp > 0 ORDER BY ptp_temp DESC");
for($x=0; $temp = $Db1->fetch_array($sql); $x++) {
	$total+=$temp[ptp_temp];
	$list.="
	<tr>
		<td>
			<input type=\"hidden\" name=\"memberIndex[$x]\" value=\"$temp[userid]\">
			<input type=\"checkbox\" value=\"1\" name=\"selected[$x]\" checked=\"checked\">
		</td>
		<td>$temp[username]</td>
		<td>$temp[country]</td>
		<td>$temp[referrals1]</td>
		<td>$temp[ptp_temp]</td>
	</tr>
	";
}


$includes[content]="
Estimated Cost: \$".round(($total*0.0002),2)."

<form action=\"admin.php?view=admin&ac=credit_ptp&action=credit&".$url_variables."\" method=\"post\">

<table>
	<tr>
		<td><b></b></td>
		<td><b>Username</b></td>
		<td><b>Country</b></td>
		<td><b>Referrals</b></td>
		<td><b>Valid PTP</b></td>
	</tr>
	$list
</table>

<input type=\"submit\" value=\"Credit Checked Accounts\">

</form>


";


?>