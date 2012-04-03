<?
$includes[title]="Signups Manager";
//**VS**//$setting[ptsu]//**VE**//
//**S**//


$includes[content].="



<script type=\"text/javascript\" src=\"includes/ajax/ptsu_functions.js\"></script>



<div id=\"returnOut\"></div>

<div style=\"float: right; display: none;\" id=\"loading_alert\"><tt style=\"color: gray\">Loading</tt> <img src='images/loading3.gif'/></div>
<ul id=\"maintab\" class=\"shadetabs\">
	<li class=\"selected\"><a href=\"#default\" rel=\"pending_admin\" rev=\"load_pending(1)\">Admin Pending</a></li>
	<li><a href=\"#\" rel=\"pending_advertiser\" rev=\"load_pending(2)\">Advertiser Pending</a></li>
</ul>


<div class=\"contentstyle\" style=\"width: 700px\">

	<div id=\"pending_admin\"   style=\"display: block\">
	</div>

	<div id=\"pending_advertiser\"   style=\"display: block\">
	</div>

</div>

<script type=\"text/javascript\">
//Start Ajax tabs script for UL with id=\"maintab\" Separate multiple ids each with a comma.
//startajaxtabs(\"maintab\")
startTabs(\"maintab\");

//update_manager(0, 10, '', '');

</script>



";
//**E**//
?>
