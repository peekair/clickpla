<?
$includes[title]="Payout Settings";
//**S**//
if(($action == "save") && ($working == 1)) {


$settings["request_pay_on"]	 	= 	"$request_pay_on";
$settings["auto_pay_on"]	 	= 	"$auto_pay_on";

//$settings[""]	 	= 	"$";




include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=payouts&saved=1&".$url_variables."");
}


$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=payouts&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Standard Request System:  </b></td>
		<td><input type=\"checkbox\" name=\"request_pay_on\" value=\"1\"".iif($settings[request_pay_on]==1," Checked=\"Checked\"")."></td>
	</tr>

	<tr class=\"tableHL1\">
		<td width=\"250\"><b>Automatic Payout System:  </b></td>
		<td><input type=\"checkbox\" name=\"auto_pay_on\" value=\"1\"".iif($settings[auto_pay_on]==1," Checked=\"Checked\"")."></td>
	</tr>


	
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>
</table>
</form>
";
//**E**//
?>
