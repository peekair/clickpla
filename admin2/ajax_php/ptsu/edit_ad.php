<?
requireAdmin();

$sql=$Db1->query("SELECT * FROM ptsuads WHERE id='$id'");
$adinfo=$Db1->fetch_array($sql);

if($adinfo[pstart] == "") {
	$adinfo[pstart]=time();
}

if($adinfo[pend] == "") {
	$adinfo[pend]=time()+2592000;
}
$desc = $adinfo[subtitle];
echo "
<div align=\"center\" style=\"margin: 10 0 0 0px\">
<div id=\"edit_ad_message\" class=\"messagebox\"></div>



<form id=\"editForm\">
			<table border=0 width=\"450\">
				<tr>
					<td colspan=2><div class=\"form_row_title\" style=\"text-align: center;\"><b><a href=\"$adinfo[target]\" target=\"_blank\">$adinfo[title]</a></b></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Id:</div></td>
					<td><div class=\"form_row_value\"> $adinfo[id]</div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Title:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[title]\" name=\"title\" size=\"40\"></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Url:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[target]\" name=\"target\" size=\"40\"></div></td>
				</tr>
                				<tr>
					<td><div class=\"form_row_title\"> Description:</td>
					<td > <textarea cols=\"50\" rows=\"4\" name=\"subtitle\">$adinfo[subtitle]</textarea></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Username:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[username]\" name=\"user\"></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Credits:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[credits]\" name=\"credits\"></div></td>
				</tr>
				<tr>
					<td>Target Country: </td>
					<td><select name=\"country\">".targetCountryList($adinfo[country])."</select></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Class:</div></td>
					<td><div class=\"form_row_value\">
						<select name=\"class\">
							<option value=\"C\"".iif($adinfo['class']=="C"," selected=\"selected\"").">Cash
							<option value=\"P\"".iif($adinfo['class']=="P"," selected=\"selected\"").">Points
						</select>
					</div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Value:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[pamount]\" name=\"pamount\"></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Signups:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[signups]\" name=\"signups\"></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Pending:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"text\" value=\"$adinfo[pending]\" name=\"pending\"></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\"> Active: </div></td>
					<td><div class=\"form_row_value\">
						<select name=\"active\">
							<option value=\"1\"".iif($adinfo['active']==1," selected=\"selected\"").">Yes
							<option value=\"0\"".iif($adinfo['active']==0," selected=\"selected\"").">No
							<option value=\"2\"".iif($adinfo['active']==2," selected=\"selected\"").">Denied
						</select>
					</div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\">Featured:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"checkbox\" value=\"1\" name=\"featured\"".iif($adinfo[featured] == 1,"checked=\"checked\"")."></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\">Premium Only:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"checkbox\" value=\"1\" name=\"premOnly\"".iif($adinfo[premium] == 1,"checked=\"checked\"")."></div></td>
				</tr>
				<tr>
					<td><div class=\"form_row_title\">Forbid Credit Retraction:</div></td>
					<td><div class=\"form_row_value\"> <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"".iif($adinfo[forbid_retract] == 1,"checked=\"checked\"")."></div></td>
				</tr>
				<tr>
					<td colspan=2 align=\"center\">
						<input type=\"button\" value=\"Save\" onclick=\"do_edit_ad($id)\">
						<input type=\"button\" value=\"Delete\" onclick=\"delete_ad($id)\">
					</td>
				</tr>
			</table>

</form>
</div>


";


/*
0	waiting approval
1	approved by admin
2	waiting approval by advertiser
3	denied by admin
4	denied by advertiser
*/



$sql=$Db1->query("SELECT * FROM ptsu_log WHERE ptsu_id='".$adinfo[id]."' ORDER BY status");
$total=$Db1->num_rows();
for($x=0; $temp=$Db1->fetch_array($sql); $x++) {
	$sql2=$Db1->query("SELECT last_ip FROM user WHERE username='$temp[username]'");
	$temp2=$Db1->fetch_array($sql2);
	$list.="
		<div class=\"borderBox\" id=\"approve_signup_main".$temp[id]."\">
			<div id=\"approve_signup".$temp[id]."\">

			".iif($temp[status]==0 || $temp[status]==2,"
				<div style=\"float: right;\">
					<a href=\"\" onclick=\"approve_signup($temp[id],1); return false;\"><b>Approve</b></a> &nbsp;&nbsp;&nbsp;
					<a href=\"\" onclick=\"approve_signup($temp[id],3); return false;\"><b>Deny</b></a> &nbsp;&nbsp;&nbsp;
					<a href=\"\" onclick=\"approve_signup($temp[id],2); return false;\">Require Advertiser Approval</a>
				</div>"
			)."
			"
			.iif($temp[status]==0,"Pending Approval")
			.iif($temp[status]==1,"Approved")
			.iif($temp[status]==2,"Waiting Advertiser Approval")
			.iif($temp[status]==3,"Denied by Admin")
			.iif($temp[status]==4,"Denied by Advertiser")

			."

				<div style=\"clear: both; height: 150px; overflow: auto; border: 1px solid #c8c8c8; background-color: white; text-align: left; padding: 5 5 5 5px\">
					<b>IP: </b> $temp2[last_ip]<br />
					<b>Username Here:</b> $temp[username]<br />
					<b>Userid Used: </b> $temp[userid]<br />
					".nl2br($temp[welcome_email])."
				</div>
			</div>
		</div>
	";
}
	echo "<hr>$list";


?>
