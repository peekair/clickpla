        <div class="panels">
            <h3>Member Benefits</h3>
            <div class="content">
                <ul>
                    <li>Here at Click-Planet you can make money by visiting our sponsors.</li>
                    <li>Yes! We even pay you to visit our page.</li>
                    <li>You can earn between .001 and .01 per clicks.</li>
                    <li>You want to earn more? Of course you do.</li>
                    <li>You can refer your friends and increase your revenue.</li>
                    <li>Register now,what do you have to lose it's 100% FREE!</li>
                </ul>
            </div>
        </div>

        <div class="panels">
            <h3>Advertiser Benefits</h3>
    		<div class="content" style="height:124px;">
            	<ul>
                    <li>High Quality Advertising</li>
                    <li>No Bots/Autoclicker can pass our super system</li>
                    <li>Ultra Low Cost Advertising</li>
                    <li>Allows Selective Country Ad-Targetting</li>
                    <li>24 hours per unique hits</li>
                    <li>Increase your site traffic instantly!</li>
                </ul>
            </div>
        </div> 


<? //// DO NOT EDIT BELOW THIS LINE UNLESS YOU KNOW WHAT YOUR DOING


if($settings[special_homepage] == 1) echo advspecial();
if(($settings[popupon] == 1) && (($freshvisit == 1) || ($settings[popuponce] != 1))) {
	$sql=$Db1->query("SELECT * FROM popups WHERE credits >=1 ORDER BY RAND() LIMIT 1");
	if($Db1->num_rows() != 0) {
		echo "
		<script type=\"text/javascript\">
		var force=0
		function setwinfocus() {
			window.focus()
		}

		window.open('loadpopup.php?ref=$ref','PaidToPromote','width=790,height=500,left=10,top=10,toolbar=yes,menubar=no,scrollbars=yes,status=yes,resizable=yes,location=yes');
		setTimeout(\"setwinfocus()\",1500);

		</script>
		";
	}
}
?>