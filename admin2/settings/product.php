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
$includes[title]="Site Settings";
//**S**//
if(($action == "save") && ($working == 1)) {

$settings["flink_marquee_price"]		=	"$flink_marquee_price";
$settings["flink_hl_price"]				=	"$flink_hl_price";
$settings["link_hl_price"]				=	"$link_hl_price";
$settings["class_a_credit_ratio"]		=	"$class_a_credit_ratio";
$settings["class_b_credit_ratio"]		=	"$class_b_credit_ratio";
$settings["class_c_credit_ratio"]		=	"$class_c_credit_ratio";
$settings["class_d_credit_ratio"]		=	"$class_d_credit_ratio";
$settings["ptr_earn"]					=	"$ptr_earn";
$settings["ptr_packages"]				=	"$ptr_packages";
$settings["ptr_ratio"]					=	"$ptr_ratio";
$settings["ptr_time"]					=	"$ptr_time";
$settings["game_points_ratio"]			=	"$game_points_ratio";
$settings["surf_ratio"]					=	"$surf_ratio";
$settings["surf_packages"]				=	"$surf_packages";
$settings["sellpopups"]					=	"$sellpopups";
$settings["sellgamehits"]				=	"$sellgamehits";
$settings["sellptr"]					=	"$sellptr";
$settings["sellptra"]					=	"$sellptra";
$settings["game_points_sell"]			=	"$game_points_sell";
$settings["sellse"]						=	"$sellse";
$settings["sellfad"]					=	"$sellfad";
$settings["sellbanner"]					=	"$sellbanner";
$settings["sellfbanner"]				=	"$sellfbanner";
$settings["sellflink"]					=	"$sellflink";
$settings["sell_referrals"]				=	"$sell_referrals";
$settings["sell_links"]					=	"$sell_links";
$settings["ghit_ratio"]					=	"$ghit_ratio";
$settings["ghit_packages"]				= 	"$ghit_packages";
$settings["fbanner_ratio"]				=	"$fbanner_ratio";
$settings["referral_price"]				=	"$referral_price";
$settings["referral_packages"]			=	"$referral_packages";
$settings["popup_packages"]				=	"$popup_packages";
$settings["popup_ratio"]				=	"$popup_ratio";
$settings["base_price"]	 				= 	"$base_price";
$settings["link_ratio"]	 				= 	"$link_ratio";
$settings["fad_ratio"]	 				= 	"$fad_ratio";
$settings["banner_ratio"]	 			= 	"$banner_ratio";
$settings["flink_cost"]	 				= 	"$flink_cost";
$settings["buy_fee"]	 				= 	"$buy_fee";
$settings["link_packages"]	 			= 	"$link_packages";
$settings["banner_packages"]			= 	"$banner_packages";
$settings["fbanner_packages"]			= 	"$fbanner_packages";
$settings["fad_packages"]	 			= 	"$fad_packages";
$settings["flink_packages"] 			= 	"$flink_packages";
$settings["game_points_packages"]		=	"$game_points_packages";
$settings["credit_ratio"] 				= 	"$credit_ratio";
$settings["class_a_ratio"] 	 			= 	"$class_a_ratio";
$settings["class_b_ratio"] 	 			= 	"$class_b_ratio";
$settings["class_c_ratio"] 	 			= 	"$class_c_ratio";
$settings["class_d_ratio"] 	 			= 	"$class_d_ratio";
$settings["class_a_earn"] 				= 	"$class_a_earn";
$settings["class_b_earn"] 				= 	"$class_b_earn";
$settings["class_c_earn"] 		 		= 	"$class_c_earn";
$settings["class_d_earn"] 		 		= 	"$class_d_earn";
$settings["class_a_time"] 		 		= 	"$class_a_time";
$settings["class_b_time"] 		 		= 	"$class_b_time";
$settings["class_c_time"] 		 		= 	"$class_c_time";
$settings["class_d_time"] 		 		= 	"$class_d_time";
$settings["ptr_a_time"]					=	"$ptr_a_time";
$settings["ptr_b_time"]					=	"$ptr_b_time";
$settings["ptr_c_time"]					=	"$ptr_c_time";
$settings["ptr_d_time"]					=	"$ptr_d_time";
$settings["ptr_a_earn"]					=	"$ptr_a_earn";
$settings["ptr_b_earn"]					=	"$ptr_b_earn";
$settings["ptr_c_earn"]					=	"$ptr_c_earn";
$settings["ptr_d_earn"]					=	"$ptr_d_earn";
$settings["ptr_a_ratio"]				=	"$ptr_a_ratio";
$settings["ptr_b_ratio"]				=	"$ptr_b_ratio";
$settings["ptr_c_ratio"]				=	"$ptr_c_ratio";
$settings["ptr_d_ratio"]				=	"$ptr_d_ratio";
$settings["ptr_a_credit_ratio"]			= 	"$ptr_a_credit_ratio";
$settings["ptr_b_credit_ratio"]			= 	"$ptr_b_credit_ratio";
$settings["ptr_c_credit_ratio"]			= 	"$ptr_c_credit_ratio";
$settings["ptr_d_credit_ratio"]			= 	"$ptr_d_credit_ratio";
$settings["sell_ptra"]					=	"$sell_ptra";
$settings["ptra_packages"]				=	"$ptra_packages";

$settings["iconCost"]            =   "$iconCost";
$settings["subtitleCost"]         =   "$subtitleCost";
$settings["x_packages"]				=	"$x_packages";
$settings["sellce"]					=	"$sellce";
$settings["x_ratio"]					=	"$x_ratio";

$settings["ptsu_cost"]				=	"$ptsu_cost";
$settings["ptsu_value"]				=	"$ptsu_value";
$settings["sell_ptsu"]				=	"$sell_ptsu";
$settings["ptsu_packages"]			=	"$ptsu_packages";
$settings["buy_percent"]	 				= 	"$buy_percent";
$settings["bogomembership"]	 				= 	"$bogomembership";
$settings["bogorefs"]	 				= 	"$bogorefs";
$settings["bog_amount"]	 				= 	"$bog_amount";






include("admin2/settings/update.php");
updatesettings($settings);

//	foreach ($settingarray as $f => $s) {
//	    $Db1->query("UPDATE settings SET setting='$s' WHERE title='$f'");
//	}
	$Db1->sql_close();
	header("Location: admin.php?view=admin&ac=settings&type=product&saved=1&".$url_variables."");
}


if ($settings[currency] == "$") {
    $cursym = '$';
}
if ($settings[currency] == "GBP") {
    $cursym = '&pound;';
}
if ($settings[currency] == "EUR") {
    $cursym = '&euro;';
}
//onsubmit=\"return verifyfields(this)\"

$includes[content]="
".iif($saved==1,"<font color=\"darkgreen\">The settings have been saved</font>")."
<form action=\"admin.php?view=admin&ac=settings&action=save&type=product&".$url_variables."\" method=\"post\" name=\"form\">
<input type=\"hidden\" name=\"working\" value=\"1\">
<table width=\"100%\">

	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt; color: darkblue\">Product Settings</font></b></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\">
	
	<script>
		function calc_link_cost() {
			var base_price = document.form.base_price.value*1;
			var buy_fee = document.form.buy_fee.value*1;

		".iif(SETTING_PTC==true,"
			var a_earns = document.form.class_a_earn.value*1;
			var b_earns = document.form.class_b_earn.value*1;
			var c_earns = document.form.class_c_earn.value*1;
			var d_earns = document.form.class_d_earn.value*1;")."

		".iif(SETTING_PTRA==true,"
			var ptra_earns = document.form.ptr_a_earn.value*1;
			var ptrb_earns = document.form.ptr_b_earn.value*1;
			var ptrc_earns = document.form.ptr_c_earn.value*1;
			var ptrd_earns = document.form.ptr_d_earn.value*1;")."

		".iif(SETTING_PTR==true,"
			var ptr_earns = document.form.ptr_earn.value*1;")."

		".iif(SETTING_PTC==true,"
			var a_ratio = document.form.class_a_ratio.value*1;
			var b_ratio = document.form.class_b_ratio.value*1;
			var c_ratio = document.form.class_c_ratio.value*1;
			var d_ratio = document.form.class_d_ratio.value*1;")."

		".iif(SETTING_PTRA==true,"
			var ptra_ratio = document.form.ptr_a_ratio.value*1;
			var ptrb_ratio = document.form.ptr_b_ratio.value*1;
			var ptrc_ratio = document.form.ptr_c_ratio.value*1;
			var ptrd_ratio = document.form.ptr_d_ratio.value*1;")."

			".iif(SETTING_PTR==true,"var ptr_ratio = document.form.ptr_ratio.value*1;")."
			".iif(SETTING_SE==true,"var surf_ratio = document.form.surf_ratio.value*1;")."
			".iif(SETTING_CE==true,"var x_ratio = document.form.x_ratio.value*1;")."
			var banner_ratio = document.form.banner_ratio.value*1;
			var fbanner_ratio = document.form.fbanner_ratio.value*1;
			var fad_ratio = document.form.fad_ratio.value*1;
			".iif(SETTING_PTP==true,"var popup_ratio = document.form.popup_ratio.value*1;")."
			".iif(SETTING_GAMES==true,"var ghit_ratio = document.form.ghit_ratio.value*1;")."
			

		".iif(SETTING_PTC==true,"
			document.form.class_a_cost2.value=(1000*a_earns)
			document.form.class_b_cost2.value=(1000*b_earns)
			document.form.class_c_cost2.value=(1000*c_earns)
			document.form.class_d_cost2.value=(1000*d_earns)")."

		".iif(SETTING_PTRA==true,"
			document.form.ptr_a_cost2.value=(1000*ptra_earns)
			document.form.ptr_b_cost2.value=(1000*ptrb_earns)
			document.form.ptr_c_cost2.value=(1000*ptrc_earns)
			document.form.ptr_d_cost2.value=(1000*ptrd_earns)")."

			".iif(SETTING_PTR==true,"document.form.ptr_cost2.value=(1000*ptr_earns)")."

		".iif(SETTING_PTC==true,"
			document.form.class_a_cost.value=((a_ratio*base_price)+(buy_fee))
			document.form.class_b_cost.value=((b_ratio*base_price)+(buy_fee))
			document.form.class_c_cost.value=((c_ratio*base_price)+(buy_fee))
			document.form.class_d_cost.value=((d_ratio*base_price)+(buy_fee))")."

		".iif(SETTING_PTRA==true,"
			document.form.ptr_a_cost.value=((ptra_ratio*base_price)+(buy_fee))
			document.form.ptr_b_cost.value=((ptrb_ratio*base_price)+(buy_fee))
			document.form.ptr_c_cost.value=((ptrc_ratio*base_price)+(buy_fee))
			document.form.ptr_d_cost.value=((ptrd_ratio*base_price)+(buy_fee))")."

			".iif(SETTING_CE==true,"document.form.x_cost.value=((x_ratio*base_price)+(buy_fee))")."


			".iif(SETTING_SE==true,"document.form.surf_cost.value=((surf_ratio*base_price)+(buy_fee))")."
			".iif(SETTING_PTR==true,"document.form.ptr_cost.value=((ptr_ratio*base_price)+(buy_fee))")."
			".iif(SETTING_GAMES==true,"document.form.ghit_cost.value=((ghit_ratio*base_price)+(buy_fee))")."
			".iif(SETTING_PTP==true,"document.form.popup_cost.value=((popup_ratio*base_price)+(buy_fee))")."
			document.form.banner_cost.value=((base_price/banner_ratio)+(buy_fee))
			document.form.fbanner_cost.value=((base_price/fbanner_ratio)+(buy_fee))
			document.form.fad_cost.value=((base_price/fad_ratio)+(buy_fee))
		}
	</script>
		
		
		<table width=\"100%\">
			<tr>
				<td></td>
				<td></td>
				<td align=\"center\">Price Ratio</b></td>
				<td align=\"center\">Time <a href=\"javascript:alert('How many seconds must the user view the site before getting paid?')\" title=\"Help Me!\">?</a></b></td>
				<td align=\"center\">Earnings <a href=\"javascript:alert('How much will each user be given for clicking this link?')\" title=\"Help Me!\">?</a></b></td>
				<td align=\"center\">CC <a href=\"javascript:alert('How many link credits convert to the class credit?')\" title=\"Help Me!\">?</a></b></td>
				<td align=\"center\">CPM <a href=\"javascript:alert('Real-time stats of Cost Per Thousand for each item.')\" title=\"Help Me!\">?</a></b></td>
				<td align=\"center\">Cost <a href=\"javascript:alert('How much it will cost you per 1000 credtis.')\" title=\"Help Me!\">?</a></b></td>
			</tr>".iif(SETTING_PTC==true,"
			<tr>
				<td rowspan=4><input type=\"checkbox\" name=\"sell_links\" value=\"1\"".iif($settings[sell_links] == 1,"checked=\"checked\"")."></td>
				<td>Link Class A <a href=\"javascript:alert('Raw Credits Needed For 1 Class A Link Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"class_a_ratio\" value=\"$settings[class_a_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_a_time\" value=\"$settings[class_a_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_a_earn\" value=\"$settings[class_a_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_a_credit_ratio\" value=\"$settings[class_a_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_a_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_a_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td>Link Class B <a href=\"javascript:alert('Raw Credits Needed For 1 Class B Link Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"class_b_ratio\" value=\"$settings[class_b_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_b_time\" value=\"$settings[class_b_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_b_earn\" value=\"$settings[class_b_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_b_credit_ratio\" value=\"$settings[class_b_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_b_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_b_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td>Link Class C <a href=\"javascript:alert('Raw Credits Needed For 1 Class C Link Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"class_c_ratio\" value=\"$settings[class_c_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_c_time\" value=\"$settings[class_c_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_c_earn\" value=\"$settings[class_c_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_c_credit_ratio\" value=\"$settings[class_c_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_c_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_c_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td>Link Class D <a href=\"javascript:alert('Raw Credits Needed For 1 Class D Link Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"class_d_ratio\" value=\"$settings[class_d_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_d_time\" value=\"$settings[class_d_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_d_earn\" value=\"$settings[class_d_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"class_d_credit_ratio\" value=\"$settings[class_d_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_d_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"class_d_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
   <td><input type=\"checkbox\" name=\"sell_links\" value=\"1\"".iif($settings[sell_links] == 1,"checked=\"checked\"")."></td>
   <td>Link Subtitle Price</td>
   <td align=\"center\">$cursym<input type=\"text\" name=\"subtitleCost\" value=\"$settings[subtitleCost]\" size=\"5\"></td>
   <td colspan=2> </td>
</tr>
<tr>
   <td><input type=\"checkbox\" name=\"sell_links\" value=\"1\"".iif($settings[sell_links] == 1,"checked=\"checked \"")."></td>
   <td>Link Icon Price</td>
   <td align=\"center\">$cursym<input type=\"text\" name=\"iconCost\" value=\"$settings[iconCost]\" size=\"5\"></td>
   <td colspan=2> </td>
</tr>
<tr>
   <td><input type=\"checkbox\" name=\"sell_links\" value=\"1\"".iif($settings[sell_links] == 1,"checked=\"checked\"")."></td>
   <td>Link Highlight Price</td>
   <td align=\"center\">$cursym<input type=\"text\" name=\"link_hl_price\" value=\"$settings[link_hl_price]\" size=\"5\"></td>
   <td colspan=2> </td>
</tr>
<tr>
   <td></td>
   <td>-----------------------------------</td>
</tr>
")."
			".iif(SETTING_PTRA==true,"
			<tr>
				<td rowspan=4><input type=\"checkbox\" name=\"sell_ptra\" value=\"1\"".iif($settings[sell_ptra] == 1,"checked=\"checked\"")."></td>
				<td>PTR Ads Class A <a href=\"javascript:alert('Raw Credits Needed For 1 Class A PTR Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_a_ratio\" value=\"$settings[ptr_a_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_a_time\" value=\"$settings[ptr_a_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_a_earn\" value=\"$settings[ptr_a_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_a_credit_ratio\" value=\"$settings[ptr_a_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_a_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_a_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td>PTR Ads Class B <a href=\"javascript:alert('Raw Credits Needed For 1 Class B PTR Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_b_ratio\" value=\"$settings[ptr_b_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_b_time\" value=\"$settings[ptr_b_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_b_earn\" value=\"$settings[ptr_b_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_b_credit_ratio\" value=\"$settings[ptr_b_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_b_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_b_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td>PTR Ads Class C <a href=\"javascript:alert('Raw Credits Needed For 1 Class C PTR Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_c_ratio\" value=\"$settings[ptr_c_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_c_time\" value=\"$settings[ptr_c_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_c_earn\" value=\"$settings[ptr_c_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_c_credit_ratio\" value=\"$settings[ptr_c_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_c_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_c_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td>PTR Ads Class D <a href=\"javascript:alert('Raw Credits Needed For 1 Class D PTR Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_d_ratio\" value=\"$settings[ptr_d_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_d_time\" value=\"$settings[ptr_d_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_d_earn\" value=\"$settings[ptr_d_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_d_credit_ratio\" value=\"$settings[ptr_d_credit_ratio]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_d_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_d_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>")."
				".iif(SETTING_SE==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"sellse\" value=\"1\"".iif($settings[sellse] == 1,"checked=\"checked\"")."></td>
				<td>Surf Hits <a href=\"javascript:alert('Raw Credits Needed For 1 Surf Exchange Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"surf_ratio\" value=\"$settings[surf_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"surf_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\"></td>
			</tr>")."
				".iif(SETTING_CE==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"sellce\" value=\"1\"".iif($settings[sellce] == 1,"checked=\"checked\"")."></td>
				<td>X-Credits <a href=\"javascript:alert('Raw Credits Needed For 1 Click Exchange Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"x_ratio\" value=\"$settings[x_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"x_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\"></td>
			</tr>")."
				".iif(SETTING_PTR==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"sellptr\" value=\"1\"".iif($settings[sellptr] == 1,"checked=\"checked\"")."></td>
				<td>Paid Emails <a href=\"javascript:alert('Raw Credits Needed For 1 Email Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_ratio\" value=\"$settings[ptr_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"><input type=\"text\" name=\"ptr_time\" value=\"$settings[ptr_time]\" size=\"3\"></td> 
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_earn\" value=\"$settings[ptr_earn]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptr_cost2\" size=\"3\" disabled=\"true\"></td>
			</tr>")."
				".iif(SETTING_GAMES==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"sellgamehits\" value=\"1\"".iif($settings[sellgamehits] == 1,"checked=\"checked\"")."></td>
				<td>Game Site Hits <a href=\"javascript:alert('Raw Credits Needed For 1 Game Site Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"ghit_ratio\" value=\"$settings[ghit_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"></td> 
				<td align=\"center\"></td>
				<td align=\"center\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ghit_cost\" size=\"3\" disabled=\"true\"></td>
				<td align=\"center\"></td>
			</tr>")."
				".iif(SETTING_PTP==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"sellpopups\" value=\"1\"".iif($settings[sellpopups] == 1,"checked=\"checked\"")."></td>
				<td>Popups <a href=\"javascript:alert('Raw Credits Needed For 1 Popup Credit - CPM Cost = (Ratio * Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"popup_ratio\" value=\"$settings[popup_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td></td>
				<td></td>
				<td align=\"center\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"popup_cost\" size=\"3\" disabled=\"true\"></td>
			</tr>")."
				".iif(SETTING_GAMES==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"game_points_sell\" value=\"1\"".iif($settings[game_points_sell] == 1,"checked=\"checked\"")."></td>
				<td>Game Points <a href=\"javascript:alert('How many Raw Credits For 1 Game Point')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"game_points_ratio\" value=\"$settings[game_points_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
			</tr>
				")."
			<tr>
				<td><input type=\"checkbox\" name=\"sellfad\" value=\"1\"".iif($settings[sellfad] == 1,"checked=\"checked\"")."></td>
				<td>Featured Ad <a href=\"javascript:alert('How many F.Ad Credits For 1 Raw Credit - (1000 * Ratio) Credits = (Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"fad_ratio\" value=\"$settings[fad_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td></td>
				<td></td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"fad_cost\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td><input type=\"checkbox\" name=\"sellbanner\" value=\"1\"".iif($settings[sellbanner] == 1,"checked=\"checked\"")."></td>
				<td>Banner <a href=\"javascript:alert('How many Banner Credits For 1 Raw Credit - (1000 * Ratio) Credits = (Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"banner_ratio\" value=\"$settings[banner_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\"></td>
				<td></td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"banner_cost\" size=\"3\" disabled=\"true\"></td>
			</tr>
			<tr>
				<td><input type=\"checkbox\" name=\"sellfbanner\" value=\"1\"".iif($settings[sellfbanner] == 1,"checked=\"checked\"")."></td>
				<td>Featured Banner <a href=\"javascript:alert('How many featured Banner Credits For 1 Raw Credit - (1000 * Ratio) Credits = (Base Price)')\" title=\"Help Me!\">?</a></td>
				<td align=\"center\"><input type=\"text\" name=\"fbanner_ratio\" value=\"$settings[fbanner_ratio]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td align=\"center\">Price</td>
				<td></td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"fbanner_cost\" size=\"3\" disabled=\"true\"></td>
			</tr>
			
			".iif(SETTING_PTSU==true,"
			<tr>
				<td><input type=\"checkbox\" name=\"sell_ptsu\" value=\"1\"".iif($settings[sell_ptsu] == 1,"checked=\"checked\"")."></td>
				<td>Paid Signups</td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptsu_cost\" value=\"$settings[ptsu_cost]\" size=\"5\"></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"ptsu_value\" value=\"$settings[ptsu_value]\" size=\"5\"></td>
			</tr>")."
			<tr>
				<td><input type=\"checkbox\" name=\"sellflink\" value=\"1\"".iif($settings[sellflink] == 1,"checked=\"checked\"")."></td>
				<td>Featured Link</td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"flink_cost\" value=\"$settings[flink_cost]\" size=\"5\"></td>
				<td colspan=2> Per Month</td>
			</tr>
			<tr>
   <td><input type=\"checkbox\" name=\"sellflink\" value=\"1\"".iif($settings[sellflink] == 1,"checked=\"checked\"")."></td>
   <td>Featured Link Highlight Price</td>
   <td></td>
   <td align=\"center\">$cursym<input type=\"text\" name=\"flink_hl_price\" value=\"$settings[flink_hl_price]\" size=\"5\"></td>
   <td colspan=2> Per Month</td>
</tr>
<tr>
   <td><input type=\"checkbox\" name=\"sellflink\" value=\"1\"".iif($settings[sellflink] == 1,"checked=\"checked\"")."></td>
   <td>Featured Link Marquee Price</td>
   <td></td>
   <td align=\"center\">$cursym<input type=\"text\" name=\"flink_marquee_price\" value=\"$settings[flink_marquee_price]\" size=\"5\"></td>
   <td colspan=2> Per Month</td>
</tr>
			<tr>
				<td><input type=\"checkbox\" name=\"sell_referrals\" value=\"1\"".iif($settings[sell_referrals] == 1,"checked=\"checked\"")."></td>
				<td>Referral Price</td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"referral_price\" value=\"$settings[referral_price]\" size=\"5\"></td>
				<td><small>Each</small></td>
			</tr>
			<tr>
				<td></td>
				<td colspan=2><b>Base Price</b> (Raw Credit CPM)</td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"base_price\" value=\"$settings[base_price]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
			</tr>
			<tr>
				<td></td>
				<td><b>Buy Fee</b></td>
				<td></td>
				<td align=\"center\">$cursym<input type=\"text\" name=\"buy_fee\" value=\"$settings[buy_fee]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td colspan=4><small>Set amount to add to each order</small></td>
			</tr>
			<tr>
				<td></td>
				<td><b>Buy Percentage</b></td>
				<td></td>
				<td align=\"center\">%<input type=\"text\" name=\"buy_percent\" value=\"$settings[buy_percent]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td colspan=4><small>Extra Percentage besides buy fee to add to each order example .10 is 10% .20 is 20%</small></td>
			</tr>
			<tr>
				<td></td>
				<td><b>BOGO Credits</b></td>
				<td></td>
				<td align=\"center\">Multiply Orders By:<input type=\"text\" name=\"bog_amount\" value=\"$settings[bog_amount]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td colspan=4><small>Set number to multiply purchases by example 1 2 3 etc  Default is 1 Do not set to 0 or leave blank</small></td>
		   	</tr>
            	<tr>
				<td></td>
				<td><b>BOGO Memberships</b></td>
				<td></td>
				<td align=\"center\">Multiply Upgrades By:<input type=\"text\" name=\"bogomembership\" value=\"$settings[bogomembership]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td colspan=4><small>Set number to multiply purchases by example 1 2 3 etc  Default is 1 Do not set to 0 or leave blank</small></td>
		   	</tr>
            	<tr>
				<td></td>
				<td><b>BOGO Referrals</b></td>
				<td></td>
				<td align=\"center\">Multiply Referrals By:<input type=\"text\" name=\"bogorefs\" value=\"$settings[bogorefs]\" size=\"5\" onkeyup=\"calc_link_cost()\"></td>
				<td colspan=4><small>Set number to multiply purchases by example 1 2 3 etc  Default is 1 Do not set to 0 or leave blank</small></td>
		             	</tr>
		</table>
		
		<script>
			setTimeout('calc_link_cost()',100);
		</script>
		
		
		</td>
	</tr>
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>















	<tr>
		<td colspan=2 height=1 bgcolor=\"darkblue\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"center\"><b><font style=\"font-size: 15pt; color: darkblue\">Product Package Settings</font></b></td>
	</tr>
	".iif(SETTING_PTC==true,"
		<tr>
			<td width=\"250\"><b>Link Ads: </b></td>
			<td><input type=\"text\" name=\"link_packages\" value=\"$settings[link_packages]\" size=\"50\"></td>
		</tr>")."
	".iif(SETTING_PTSU==true,"
		<tr>
			<td width=\"250\"><b>Paid Signups: </b></td>
			<td><input type=\"text\" name=\"ptsu_packages\" value=\"$settings[ptsu_packages]\" size=\"50\"></td>
		</tr>")."
	".iif(SETTING_PTR==true,"
		<tr>
			<td width=\"250\"><b>Email Hits: </b></td>
			<td><input type=\"text\" name=\"ptr_packages\" value=\"$settings[ptr_packages]\" size=\"50\"></td>
		</tr>")."
	".iif(SETTING_PTRA==true,"
		<tr>
			<td width=\"250\"><b>PTR Ads: </b></td>
			<td><input type=\"text\" name=\"ptra_packages\" value=\"$settings[ptra_packages]\" size=\"50\"></td>
		</tr>")."
	".iif(SETTING_SE==true,"
		<tr>
			<td width=\"250\"><b>Surf Hits: </b></td>
			<td><input type=\"text\" name=\"surf_packages\" value=\"$settings[surf_packages]\" size=\"50\"></td>
		</tr>")."
	".iif(SETTING_CE==true,"
		<tr>
			<td width=\"250\"><b>X-Credits: </b></td>
			<td><input type=\"text\" name=\"x_packages\" value=\"$settings[x_packages]\" size=\"50\"></td>
		</tr>")."
	<tr>
		<td width=\"250\"><b>Banner Ads: </b></td>
		<td><input type=\"text\" name=\"banner_packages\" value=\"$settings[banner_packages]\" size=\"50\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Featured Banner Ads: </b></td>
		<td><input type=\"text\" name=\"fbanner_packages\" value=\"$settings[fbanner_packages]\" size=\"50\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Featured Ads: </b></td>
		<td><input type=\"text\" name=\"fad_packages\" value=\"$settings[fad_packages]\" size=\"50\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Featured Links: </b></td>
		<td><input type=\"text\" name=\"flink_packages\" value=\"$settings[flink_packages]\" size=\"50\"></td>
	</tr>".iif(SETTING_PTP==true,"
	<tr>
		<td width=\"250\"><b>Popups: </b></td>
		<td><input type=\"text\" name=\"popup_packages\" value=\"$settings[popup_packages]\" size=\"50\"></td>
	</tr>")."".iif(SETTING_GAMES==true,"
	<tr>
		<td width=\"250\"><b>Game Site Hits: </b></td>
		<td><input type=\"text\" name=\"ghit_packages\" value=\"$settings[ghit_packages]\" size=\"50\"></td>
	</tr>
	<tr>
		<td width=\"250\"><b>Game Points: </b></td>
		<td><input type=\"text\" name=\"game_points_packages\" value=\"$settings[game_points_packages]\" size=\"50\"></td>
	</tr>")."
	<tr>
		<td width=\"250\"><b>Referrals: </b></td>
		<td><input type=\"text\" name=\"referral_packages\" value=\"$settings[referral_packages]\" size=\"50\"></td>
	</tr>
	<tr>
		<td colspan=2 align=\"right\"><input type=\"submit\" value=\"Save\"></td>
	</tr>

</table>
<div align=\"right\"></div>
</form>
";
//**E**//
?>