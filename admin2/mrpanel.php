	<link rel="stylesheet" href="templates/<?=$settings['template'];?>/admin.css" type="text/css" /><?

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

$includes[title]="Admin Panel";



$includes[content].="
<center>

		<div id=\"userMenu\">
					<ul>
						<li class=\"um_account\"><a href=\"admin.php?ac=stats&".$url_variables."\"><span>Stats</a></span></li>
						<li class=\"um_downline\"><a href=\"admin.php?ac=statsDaily&".$url_variables."\"><span>DailyStats</a></span></li>

						<li class=\"um_manage\"><a href=\"admin.php?ac=alexa&".$url_variables."\"><span>Alexa</a></span></li>
					
			<li class=\"um_credit_card\">
<a href=\"admin.php?ac=settings&type=payments&".$url_variables."\"><span>Pay Settings</a></span></li>
<li class=\"um_refresh\">
<a href=\"admin.php?ac=settings&type=converter&".$url_variables."\"><span>Converter</a></span></li>
<li class=\"um_report\">
<a href=\"admin.php?ac=settings&type=howmuch&".$url_variables."\"><span>User Breakdown</a></span></li>
<li class=\"um_coins\">
<a href=\"admin.php?ac=settings&type=withdraw&".$url_variables."\"><span>Withdraw</a></span></li>
<li class=\"um_pie_chart\">
<a href=\"admin.php?ac=logs&".$url_variables."\"><span>Site Logs</a></span></li>
<li class=\"um_pie_chart\">
<a href=\"admin.php?ac=errorLog&".$url_variables."\"><span>Error Logs</a></span></li>
<li class=\"um_cheat\">
<a href=\"admin.php?ac=cheat_check_failed&".$url_variables."\"><span>Cheaters Log</a></span></li>
<li class=\"um_bk\">
<a href=\"admin.php?ac=backup&".$url_variables."\"><span>Backup</a></span></li>





<li class=\"um_edit\">
<a href=\"admin.php?ac=members&".$url_variables."\"><span>Members</a></span></li>


<li class=\"um_arefs\">
<a href=\"admin.php?ac=assignreferrals&".$url_variables."\"><span>Assign Refs</a></span></li>

<li class=\"um_foot\">
<a href=\"admin.php?ac=footprints&".$url_variables."\"><span>Footprints</a></span></li>

<li class=\"um_help\">
<a href=\"admin.php?ac=help&".$url_variables."\"><span>FAQ</a></span></li>

<li class=\"um_penduser\">
<a href=\"admin.php?ac=approvejoins&".$url_variables."\"><span>Approve Users</a></span></li>

<li class=\"um_faq\">
<a href=\"admin.php?ac=templates&".$url_variables."\"><span>Create A Page</a></span></li>










<li class=\"um_delete\">
<a href=\"admin.php?ac=db_clean&".$url_variables."\"><span>Clean Logs</a></span></li>

<li class=\"um_message\">
<a href=\"admin.php?ac=settings&type=im&".$url_variables."\"><span>PM Settings</a></span></li>

<li class=\"um_search\">
<a href=\"admin.php?ac=tracker&".$url_variables."\"><span>Tracker</a></span></li>
						<li class=\"um_logout\"><a href=\"admin.php?ac=ledger&".$url_variables."\"><span>Ledger</a></span></li>
						<li class=\"um_surf\"><a href=\"admin.php?ac=pending_orders&".$url_variables."\"><span>Pending Orders</a></span></li>

						<li class=\"um_withdraw\"><a href=\"admin.php?ac=unpaidOrders&".$url_variables."\"><span>Unprocessed </a></span></li>
	
					<li class=\"um_cart\">
<a href=\"admin.php?ac=settings&type=product&".$url_variables."\"><span>Products</a></span></li>

<li class=\"um_mspec\">
<a href=\"admin.php?ac=specials&".$url_variables."\"><span>Manage Specials</a></span></li>

<li class=\"um_aspec\">
<a href=\"admin.php?ac=assign_special&".$url_variables."\"><span>Assign Special</a></span></li>

<li class=\"um_pstore\">
<a href=\"admin.php?ac=point_store&".$url_variables."\"><span>Point Store</a></span></li>

<li class=\"um_lott\">
<a href=\"admin.php?ac=settings&type=lottery&".$url_variables."\"><span>Lottery</a></span></li>

	<li class=\"um_mailsend\">
<a href=\"admin.php?ac=mailer&".$url_variables."\"><span>Mailer</a></span></li>
					</ul>
				</div>


<div id=\"userMenu1\">
					<ul>
						<li class=\"um_logout\"><a href=\"admin.php?ac=payouts&".$url_variables."\"><span>Make Payouts</a></span></li>
						<li class=\"um_surf\"><a href=\"admin.php?ac=withdraw_options&".$url_variables."\"><span>Options</a></span></li>

									<li class=\"um_mailm\">
<a href=\"admin.php?ac=mailer_manage&".$url_variables."\"><span>Mailer Manage</a></span></li>
                                                                   <li class=\"um_downline\">
<a href=\"admin.php?ac=code_rotator&".$url_variables."\"><span>Code Rotator</a></span></li>



	<li class=\"um_sset\">
<a href=\"admin.php?ac=settings&type=site&".$url_variables."\"><span>Site Settings</a></span></li>

	<li class=\"um_topd\">
<a href=\"admin.php?ac=refdomains&".$url_variables."\"><span>Top Domains</a></span></li>

<li class=\"um_contest\">
<a href=\"admin.php?ac=settings&type=contest&".$url_variables."\"><span>Contests</a></span></li>


<li class=\"um_target\">
<a href=\"admin.php?ac=settings&type=targeting&".$url_variables."\"><span>Ad Targeting</a></span></li>
<li class=\"um_admess\">
<a href=\"admin.php?ac=adminmsg&".$url_variables."\"><span>Admin Messages</a></span></li>
<li class=\"um_eterms\">
<a href=\"admin.php?ac=terms&".$url_variables."\"><span>Edit Terms</a></span></li>

					</ul>
				</div>





</center>
</div>

";
//**E**//
?>
