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
//**VS**//$setting[ce]//**VE**//
//**S**//
$includes[title]="Manage Stage Earnings";


if($action == "new") {
	$sql=$Db1->query("INSERT INTO xstage SET
		title='".
				iif($mtype=="xcredits","X-Credits").
				iif($mtype=="link_credits","Link Credits").
				iif($mtype=="popup_credits","Popup Credits").
				iif($mtype=="ptr_credits","Email Credits").
				iif($mtype=="ptra_credits","PTR Credits").
				iif($mtype=="fad_credits","F. Ad Credits").
				iif($mtype=="banner_credits","Banner Credits").
				iif($mtype=="fbanner_credits","F. Banner Credits").
				iif($mtype=="balance","Cash").
				iif($mtype=="tickets","Tickets")
		."',
		type='$mtype',
		amount='$amount',
		stage='$stage',
		daily='$daily'
	");
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=xstage&".$url_variables."");
}


if($action == "delete") {
	$Db1->query("DELETE FROM xstage WHERE id='$id'");
}

$sql = $Db1->query("SELECT * FROM xstage ORDER BY amount");
while($temp=$Db1->fetch_array($sql)) {
	$list.="<option value=\"$temp[id]\">$temp[stage] Clicks - $temp[amount] $temp[title] (".iif($temp[daily]==1,"Daily","Cumulative").")";
}

$includes[content]="

<br /><br />
<div align=\"center\">




<table width=\"100%\">
	<tr>
		<td>

<form action=\"admin.php?view=admin&ac=xstage&action=delete&".$url_variables."\" method=\"post\" name=\"form2\">
<select name=\"id\" size=5>
	$list
</select>
<br />
<input type=\"submit\" value=\"Delete Bonus\"><br />
</form>

		</td>
		<td valign=\"top\"><b>Add Bonus</b><br />
<form action=\"admin.php?view=admin&ac=xstage&action=new&".$url_variables."\" method=\"post\">
			Bonus: 
				<select name=\"mtype\">
					".iif(SETTING_PTC==true,"<option value=\"link_credits\">Link Credits")."
					".iif(SETTING_PTP==true,"<option value=\"popup_credits\">Popup Credits")."
					".iif(SETTING_PTR==true,"<option value=\"ptr_credits\">Email Credits")."
					".iif(SETTING_PTRA==true,"<option value=\"ptra_credits\">PTR Credits")."
					".iif(SETTING_CE==true,"<option value=\"xcredits\">X-Credits")."
					<option value=\"fad_credits\">F. Ad Credits
					<option value=\"banner_credits\">Banner Credits
					<option value=\"fbanner_credits\">F. Banner Credits
					<option value=\"balance\">Cash
					<option value=\"tickets\">Tickets
				</select><br />
			Amount: <input type=\"text\" name=\"amount\" value=\"\"><br />
			
			Stage: <input type=\"text\" size=5 name=\"stage\"> Clicks 
			<select name=\"daily\">
				<option value=\"0\">Total
				<option value=\"1\">Daily
			</select><br />
				<input type=\"submit\" value=\"Add Bonus\">
</form>
		</td>
	</tr>
</table>

<br />




</div>

";

//**E**//
?>
