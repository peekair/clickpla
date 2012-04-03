<?
include("ajax_php/memberManager/header.php");

global $user, $id;

$sql=$Db1->query("SELECT * FROM sessions WHERE user_id='$id' LIMIT 1");
$isonline=$Db1->num_rows();


echo "<table cellspacing=\"0\" cellpadding=\"0\" border=0 class=\"tableBD1\" width=\"500\">
	<tr>
		<td nowrap>
			<table cellspacing=\"1\" cellpadding=\"0\" border=0 width=\"100%\">
				<tr class=\"tableHL1\">
					<td colspan=2 align=\"center\">Member Overview</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Status:</td>
					<td>".iif($isonline==1,"<font color=\"darkgreen\"><b>Online</b></a>","<font color=\"darkred\">Offline</a>")."</td>
				</tr>
				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Country:</td>
					<td>$user[country]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Sex:</td>
					<td>$user[sex]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Birth Year:</td>
					<td>$user[birth]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Joined:</td>
					<td>".date('M d, Y', @mktime(0,0,$user[joined],1,1,1970))."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Last Activity:</td>
					<td>".date('M d, Y', @mktime(0,0,$user[last_act],1,1,1970))."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Last IP:</td>
					<td>$user[last_ip]</td>
				</tr>

				<tr class=\"tableHL2\">
					<td nowrap>Password Hash:</td>
					<td><small style=\"color: darkblue\">$user[password]</small></td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>

				<tr class=\"tableHL2\">
					<td>Failed Logins:</td>
					<td>$user[failed_logins]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>FloodGuard Activations:</td>
					<td>$user[floodguard]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>FloodGuard Activations Today:</td>
					<td>$user[floodguard_today]</td>
				</tr>




				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Raw Referral Hits:</td>
					<td>$user[ref_hits_raw]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Unique Referral Hits:</td>
					<td>$user[ref_hits_unique]</td>
				</tr>


				".iif(SETTING_PTSU==true,"
					<tr style=\"background-color: white;\">
						<td height=5></td>
						<td></td>
					</tr>
					<tr class=\"tableHL2\">
						<td>Approved Signups: </td>
						<td>$user[ptsu_approved]</td>
					</tr>
					<tr class=\"tableHL2\">
						<td>Denied Signups: </td>
						<td>$user[ptsu_denied]</td>
					</tr>
					<tr class=\"tableHL2\">
						<td>PTSU Earnings: </td>
						<td>$user[ptsu_earnings]</td>
					</tr>

				")."

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Link Clicks:</td>
					<td>$user[clicks]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Link Clicks Today:</td>
					<td>$user[clicked_today]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Last Link Click:</td>
					<td>".date('M d, Y', @mktime(0,0,$user[last_click],1,1,1970))."</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTP Hits:</td>
					<td>$user[ptphits]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTP Hits Today:</td>
					<td>$user[ptphits_today]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTP Earnings:</td>
					<td>$user[ptpearns]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Signup Score: ".show_help("PTP Signup Score - This number helps find ptp cheaters. The number represents how many ptp hits were paid per 1 signups. The higher this number is, the higher the chance that they are using an emulator. ")."</td>
					<td>".iif($user[ptphits] > 0, @number_format(round($user[ptphits]/($user[referrals1]>0?$user[referrals1]:1))), "0")."</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Referrals (lvl 1):</td>
					<td>$user[referrals1]</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Email Clicks:</td>
					<td>$user[emails]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Email Clicks Today:</td>
					<td>$user[emails_today]</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTRA Clicks:</td>
					<td>$user[ptra_clicks]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>PTRA Clicks Today:</td>
					<td>$user[ptra_clicks_today]</td>
				</tr>

				<tr style=\"background-color: white;\">
					<td height=5></td>
					<td></td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Exchange Clicks:</td>
					<td>$user[xclicks]</td>
				</tr>
				<tr class=\"tableHL2\">
					<td>Exchange Clicks Today:</td>
					<td>$user[xclicked_today]</td>
				</tr>


			</table>
		</td>
	</tr>
</table>";

?>


