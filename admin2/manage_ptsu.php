<?
$includes[title]="Manage PTSU Ads";
//**VS**//$setting[ptsu]//**VE**//
//**S**//

if ($apsver != 5.6){
    print"This will only work on MRV Version $aspver.  Please see your retailer to upgrade your script";
    exit;
}
$includes[content].="
<script>
url_variables = '".iif($sid, "sid=".$sid."&").iif($sid2, "sid2=".$sid2."&").iif($siduid, "siduid=".$siduid."")."';
search_str='".$search_str."';
ajax_resource='ptsu';

</script>



<div id=\"returnOut\"></div>

<div style=\"float: right; display: none;\" id=\"loading_alert\"><tt style=\"color: gray\">Loading</tt> <img src='images/loading3.gif'/></div>
<ul id=\"maintab\" class=\"shadetabs\">
	<li class=\"selected\"><a href=\"#default\" rel=\"manage_ads\">Manage Ads</a></li>
	<li><a href=\"#\" rel=\"search_ads\">Search Ads</a></li>
	<li><a href=\"#\" rel=\"new_ad\">New Ad</a></li>
	<li><a href=\"#\" rel=\"edit_ad\">Edit Ad</a></li>
	<li><a href=\"#\" rel=\"approve_ads\" rev=\"approve_ads_load()\">Approve Ads</a></li>
</ul>





<div class=\"contentstyle\" style=\"width: 700px\">


	
	<div id=\"search_ads\" style=\"display: none; padding: 3px;\">
		<div align=\"center\">
		<table>
			<tr>
				<td align=\"center\">Search <input type=\"text\" name=\"search_str\" id=\"search_str\" value=\"\">
				<select id=\"search_by\">
					<option value=\"username\">Username
					<option value=\"id\">Id
					<option value=\"title\">Title
					<option value=\"target\">Url
				</select>
				<br /><input type=\"button\" value=\"Search\" onclick=\"dosearch()\"></td>
			</tr>
		</table>
		</div>
	</div>
	
	
	
	<div id=\"edit_ad\" style=\"display: none; padding: 3px;\">
		<div align=\"center\">
			You must select an ad to edit from the manage ads tab.
		</div>
	</div>







	<div id=\"new_ad\" style=\"display: none; padding: 3px;\">
		<script>
		function verifyForm() {
			
			return true;
		}
		</script>
	
		<div align=\"center\">
		<div id=\"new_ad_message\" class=\"messagebox\" style=\"display: none;\"></div>
	
		<form id=\"newAdForm\">
		<table width=\"450\">
			<tr>
				<td width=\"200\"><div class=\"form_row_title\"> Title: </div></td>
				<td><div class=\"form_row_value\"> <input type=\"text\" name=\"title\" value=\"$title\"> </div></td>
			</tr>
			<tr>
				<td><div class=\"form_row_title\"> Target Url:  </div></td>
				<td><div class=\"form_row_value\"> <input type=\"text\" name=\"target\" value=\"$target\"> </div></td>
			</tr>
            				<tr>
					<td>Description:</td>
					<td class=\"form_row_value\"><textarea cols=\"50\" rows=\"4\"  value=\"$subtitle\" name=\"subtitle\"></textarea></td>
				</tr>
			<tr>
				<td><div class=\"form_row_title\"> Username:  </div></td>
				<td><div class=\"form_row_value\"> <input type=\"text\" name=\"user\" value=\"$username\"> </div></td>
			</tr>
			<tr>
				<td><div class=\"form_row_title\"> Credits:  </div></td>
				<td><div class=\"form_row_value\"> <input type=\"text\" name=\"credits\" value=\"0\"> </div></td>
			</tr>
			<tr>
				<td><div class=\"form_row_title\"> Class:  </div></td>
				<td><div class=\"form_row_value\"> <select name=\"cclass\">
					<option value=\"C\">Cash
					<option value=\"P\">Points
				</select> </div></td>
			</tr>
			<tr>
				<td><div class=\"form_row_title\"> Value:  </div></td>
				<td><div class=\"form_row_value\">  <input type=\"text\" name=\"pamount\" value=\"\".$settings[ptsu_value].\"\"> </div></td>
			</tr>
			<tr>
				<td><div class=\"form_row_title\"> Active: </div></td>
				<td><div class=\"form_row_value\"> <input type=\"checkbox\" value=\"1\" name=\"active\" checked=\"checked\"> </div></td>
			</tr>
			<tr>
				<td><div class=\"form_row_title\"> Forbit Credit Retraction: </div></td>
				<td><div class=\"form_row_value\"> <input type=\"checkbox\" value=\"1\" name=\"forbid_retract\"> </div></td>
			</tr>
			<tr>
				<td colspan=2 align=\"center\"><input type=\"button\" value=\"Add Link\" onclick=\"create_ad()\"></td>
			</tr>
		</table>
		</form>
		</div>
	</div>




	<div id=\"manage_ads\"   style=\"display: block\">
	</div>


	<div id=\"approve_ads\"   style=\"display: block\">
	</div>



</div>

<script type=\"text/javascript\">
//Start Ajax tabs script for UL with id=\"maintab\" Separate multiple ids each with a comma.
//startajaxtabs(\"maintab\")
startTabs(\"maintab\");

update_manager(0, 10, '', '');

</script>



";
//**E**//
?>
