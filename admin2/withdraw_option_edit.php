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
$includes[title]="Edit Withdraw Option";

if($action == "save") {
	$Db1->query("UPDATE withdraw_options SET 
		title='".addslashes($title)."',
		minimum='$minimum',
		minimum_premium='$minimum_premium',
		
		mps='$mps',
		fee='$fee',
                fee_premium=' $fee_premium',
		delim='$delim',
		active='$active',
		verif='$verif'
	WHERE id='$id'");
}

$sql=$Db1->query("SELECT * FROM withdraw_options WHERE id='$id'");
if($Db1->num_rows() != 0) {
	$option=$Db1->fetch_array($sql);
	
	$includes[content]="
	<div align=\"right\"><a href=\"admin.php?view=admin&ac=withdraw_options&".$url_variables."\">Back To Withdraw Options</a></div>
	".iif($action=="save","<b style=\"color: darkred\">Your Changed Have Been Saved!</b>")."
	<div align=\"center\">
	<form action=\"admin.php?view=admin&ac=withdraw_option_edit&action=save&id=$id&".$url_variables."\" method=\"post\">
<Table cellpadding=0 cellspacing=0>
	<tr>
		<td width=100>Title: </td>
		<td><input type=\"text\" name=\"title\" value=\"".htmlentities($option[title])."\"></td>
	</tr>
	<tr>
		<td>Minimum: </td>
		<td><input type=\"text\" name=\"minimum\" value=\"$option[minimum]\" size=4></td>
	</tr>
	<tr>
		<td>Minimum (premium): </td>
		<td><input type=\"text\" name=\"minimum_premium\" value=\"$option[minimum_premium]\" size=4></td>
	</tr>
	<tr>
		<td>Fee: </td>
		<td><input type=\"text\" name=\"fee\" value=\"$option[fee]\" size=2>%</td>
	</tr>
         <tr>
      <td>Fee Premium: </td>
      <td><input type=\"text\" name=\"fee_premium\" value=\"$option[fee_premium]\" size=2>%</td>
   </tr>
	<tr>
		<td>Format</td>
		<td><input type=\"text\" name=\"mps\" value=\"$option[mps]\" size=40></td>
	</tr>
	<tr>
		<td>Deliminator</td>
		<td><input type=\"text\" name=\"delim\" value=\"$option[delim]\" size=1 style=\"text-align: center\"></td>
	</tr>
	<tr>
		<td>Active: </td>
		<td>
			<select name=\"active\">
				<option value=\"1\"".iif($option[active] == 1,"selected=\"selected\"").">Yes
				<option value=\"0\"".iif($option[active] == 0,"selected=\"selected\"").">No
			</select>
		</td>
	</tr>
	<tr>
		<td>Verification Type: </td>
		<td>
			<select name=\"verif\">
				<option value=\"\">
				<option value=\"email\"".iif($option[verif] == "email","selected=\"selected\"").">Email
				<option value=\"int\"".iif($option[verif] == "int","selected=\"selected\"").">Integer
			</select>
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
</form>
</div><br />

	";
}
else {
	$includes[content]="There was an error loading the withdraw option!";
}
?>
