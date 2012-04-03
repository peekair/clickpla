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
$includes[title]="Withdraw Options";
//**S**//
if($action == "add") {
	$sql=$Db1->query("INSERT INTO withdraw_options SET
		title='".addslashes($title)."',
		minimum='$minimum',
		mps='$mps',
		fee='$fee',
		delim='$delim',
		active='$active',
		verif='$verif'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=withdraw_options&".$url_variables."");
}


$sql=$Db1->query("SELECT * FROM withdraw_options ORDER BY title");
while($temp=$Db1->fetch_array($sql)) {
	$tablelist.="
	<tr>
		<td>$temp[title]</td>
		<td><b>$temp[delim]</b></td>
		<td>$temp[mps]</td>
		<td><input type=\"button\" value=\"Edit\" onclick=\"location.href='admin.php?view=admin&ac=withdraw_option_edit&id=$temp[id]&".$url_variables."'\"></td>
		<td><input type=\"button\" value=\"Delete\" onclick=\"if(confirm('Are you sure you want to delete this withdraw option?')) location.href='admin.php?view=admin&ac=withdraw_options&action=delete&id=$temp[id]&".$url_variables."'\"></td>
	</tr>
	";
}

if($action == "delete") {
	$sql=$Db1->query("SELECT * FROM requests WHERE accounttype='$id'");
	if($Db1->num_rows() == 0) {
		$sql=$Db1->query("DELETE FROM withdraw_options WHERE id='$id'");
		$Db1->sql_close();
		header("Location: admin.php?view=admin&ac=withdraw_options&".$url_variables."");
	}
	else {
		$includes[content]="There are pending withdraw requests for this withdraw method<br />You cant delete this untill these pending withdraws are paid.";
	}
}
else {
$includes[content]="
<table width=\"100%\">
	<tr>
		<td width=130><b>Title</b></td>
		<td width=100><b>Deliminator</b></td>
		<td width=250><b>Mass Pay Structure</b></td>
		<td></td>
	</tr>
	$tablelist
</table>

<br /><hr>

<b>New Withdraw Option</b><br />
<div align=\"center\">
<table>
	<tr>
		<td width=100><b>Field</td>
		<td><b>Description</td>
	</tr>
	<tr>
		<td>amount</td>
		<td>The amount being withdrawn</td>
	</tr>
	<tr>
		<td>account</td>
		<td>The account the money is to be sent to</td>
	</tr>
	<tr>
		<td>username</td>
		<td>The member's username</td>
	</tr>
	<tr>
		<td>{tab}</td>
		<td>Inserts a tab space for delimination</td>
	</tr>
</table>
</div>
<form action=\"admin.php?view=admin&ac=withdraw_options&action=add&".$url_variables."\" method=\"post\">

<Table cellpadding=0 cellspacing=0>
	<tr>
		<td width=100>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"".htmlentities($option[title])."\"></td>
	</tr>
	<tr>
		<td>Minimum: </td>
		<td><input type=\"text\" name=\"minimum\" value=\"0.50\" size=4></td>
	</tr>
	<tr>
		<td>Fee: </td>
		<td><input type=\"text\" name=\"fee\" value=\"1\" size=1>%</td>
	</tr>
	<tr>
		<td>Mass Pay Structure</td>
		<td><input type=\"text\" name=\"mps\" value=\"account{tab}amount{tab}USD\" size=40></td>
	</tr>
	<tr>
		<td>Deliminator</td>
		<td><input type=\"text\" name=\"delim\" value=\"{tab}\" size=3 style=\"text-align: center\"></td>
	</tr>
	<tr>
		<td>Active: </td>
		<td>
			<select name=\"active\">
				<option value=\"1\">Yes
				<option value=\"0\">No
			</select>
		</td>
	</tr>
	<tr>
		<td>Verification Type: </td>
		<td>
			<select name=\"verif\">
				<option value=\"\">
				<option value=\"email\">Email
				<option value=\"int\">Integer
			</select>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Add Withdraw Option\"></td>
	</tr>
</table>

</form>

In the field above, simply enter the mass pay structure needed for the withdraw method including the required deliminator. Do not use any \" or ' quotation marks<br />
Below are a few examples<br /><hr width=150 align=\"left\">
account<b><big>:</big></big></b>amount<br />
account<b><big>:</big></b>amount<b><big>:</big></b>username<br />
account<b><big>,</big></b>amount<br />
account<b><big>,</big></b>amount<b><big>,</big></b>username<br />
account<b>{tab}</b>amount<br />
account<b>{tab}</b>amount<b>{tab}</b>username

<hr width=150 align=\"left\">

Paypal: account<b>{tab}</b>amount<b>{tab}</b>USD<br />
e-Gold: account<b>|</b>amount<br />

";
}
//**E**//
?>


