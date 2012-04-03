<? 
include("ajax_php/memberManager/header.php"); 

global $user; 

?> 

<div class="vm_dashboard"> 

     <h2>Selected Account: <?=$user['username'];?> </h2>

	<div id="vm_menu">
		<div class="vm_linkWrapper"><div class="vm_link vl_edit">
			<h3 id="edit">Edit Member</h3>
			<p>Modify the details of this account.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_overview">
			<h3 id="overview">Account Overview</h3>
			<p>View account stats and details.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_ads">
			<h3 id="ads">View Ads</h3>
			<p>View this member's advertisements.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_membership">
			<h3 id="membership">Membership Subscription</h3>
			<p>Modify the membership level for this account.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_payments">
			<h3 id="payments">Payments</h3>
			<p>View payment history and queue.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_orders">
			<h3 id="orders">Order Ledger</h3>
			<p>View member's purchase history.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_logs">
			<h3 id="logs">Activity Logs</h3>
			<p>View member's recent activity logs.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_footprints">
			<h3 id="footprints">Footprints</h3>
			<p>View member's recent footprint tracks.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_downline">
			<h3 id="downline">Downline</h3>
			<p>View member's first-level referrals.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_pwd">
			<h3 id="pwd">Password</h3>
			<p>Modify the member's password.</p>
		</div></div>
		<div class="vm_linkWrapper"><div class="vm_link vl_delete">
			<h3 id="delete">Delete</h3>
			<p>Delete this account.</p>
		</div></div>
		
		<div class="clear"></div>
	</div>
	<div id="vm_back"><a href="#" onclick="mm.gotoMenu(); return false;">Back To Menu</a></div>
	<div id="vm_content"></div>
	
</div>


<script>
mm.userid=<?=$id;?>;
$(".vm_linkWrapper").hover(function(){
	$(this).addClass("hover");
},function(){
	$(this).removeClass("hover");
}).click(function(){
	mm.vmChange($(this).find("h3").attr("id"));
});
</script>

