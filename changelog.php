<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MRV v5.7.3 Changelog</title>
</head>

<body>
<p><b>MRV 5.7.3 (Aurora PTC) Changelog - 22nd February 2012.</b></p>

<p><b>NOTES:</b></p>

<p>Patch/Bugfix release.</p>

<p>This addresses a few minor fixes for bugs/errors discovered following general release of MRV 5.7.2</p>

<p>Uploaded to Reseller Accounts in entirety (to allow continuity for full installs) and as a patch to replace only affected files!</p>
<p>***************************************************************************************************************</p>

<p><b>CHANGES:</b></p>

<p><b>Fix</b> - Preserve 'Request Date' and add correct date of payout to 'payment_history' table - this will, in turn, display correct payment details on 'Payment Proof' page.</p>

<p><b>Fix</b> - Minor Currency display bug.</p>

<p><b>Updated</b> - Readme files to reflect new version.</p>

<p><b>Updated</b> - Admin Panel headers and Version.txt to reflect new minor version revision.</p>

<p><b>Updated</b> - Changelog</p>

<p>&nbsp;</p>
<p>***************************************************************************************************************</p>
<p><b>MRV 5.7.2 (Aurora PTC) Changelog - 31st October 2011.</b></p>

<p><b>NOTES:</b></p>

<p>Patch/Bugfix release.</p>

<p>This addresses a few minor fixes for bugs/errors discovered following general release of MRV 5.7.1</p>

<p>Uploaded to Reseller Accounts in entirety (to allow continuity for full installs) and as a patch to replace only affected files!</p>
<p>***************************************************************************************************************</p>

<p><b>CHANGES:</b></p>

<p><b>Fix</b> - In some cases Members were allowed to click own ads.</p>

<p><b>Fix</b> - In some circumstances, purchases were failing.</p>

<p><b>New</b> - Display current version and if update available with link to Authorized Resellers List (in Admin, Main Page).</p>

<p><b>Amended</b> - Added "DO NOT REPLY TO THIS EMAIL, IT WILL NEVER BE SEEN!" to Paid Emails (cron_mailer.php).</p>

<p><b>Updated</b> - Readme files to reflect new version.</p>

<p><b>Updated</b> - Admin Panel headers and Version.txt to reflect new minor version revision.</p>

<p><b>Updated</b> - Changelog</p>

<p>&nbsp;</p>
<p>***************************************************************************************************************</p>
<p><b>MRV 5.7.1 (Aurora PTC) Changelog - 17th October 2011.</b></p>

<p><b>NOTES:</b></p>

<p>Patch/Bugfix release.</p>

<p>This addresses a few minor fixes for bugs/errors discovered following general release of MRV 5.7.</p>

<p>Uploaded to Reseller Accounts in entirety (to allow continuity for full installs) and as a patch to replace only affected files!</p>
<p>***************************************************************************************************************</p>

<p><b>CHANGES:</b></p>

<p><b>Fix</b> - Display of Currency Symbols to match Site Currency Settings in Timer Bar.</p>

<p><b>Fix</b> - Re-added payment processor options (Perfect Money, Routepay and OKPay) that were removed from v5.7.</p>

<p><b>Fix</b> - Adjust Timer Bar display vertical spacing to allow correct display of Cheat Check and other images/wording.</p>

<p><b>Fix</b> - Correct Timer Bar HTML to improve display on WebTV and other browsers - Rotating Banners were obscuring Timer and Turing Symbols (timer.css, timer.php and timer2.php).</p>

<p><b>Fix</b> - Removed hard-coded '$' symbol from "Site Stats" displayed in left-hand side column of default template (layout_header.php) - is now dynamic and will change automatically if overall site currency is changed (USD, GBP or EUR).</p>

<p><b>Fixed/Added</b> - Incorrectly displayed currency symbols and added others that were missing.</p>

<p><b>Removed</b> - obsolete Cron Password setting from "Site Settings" and removed from settings.php for new installs (can be removed manually from settings.php for existing sites).</p>

<p><b>Added</b> - Changelog link to Admin header and created 'changelog.php' page.</p>

<p><b>Modified</b> - "Back To (site_name)" link in Admin, to open in new tab/window.</p>

<p><b>Modified</b> - Default Template (layout.php) to open 'Admin' link in new tab/window.</p>

<p><b>Updated/Clarified</b> - Readme files, created Upgrade Readme for Pre MRV5 version and Patch Readme (in Patch zip archive only).</p>

<p><b>Updated</b> - Admin Panel headers and Version.txt to reflect new minor version revision.</p>

<p><b>Updated</b> - Changelog</p>

<p>&nbsp;</p>
<p>***************************************************************************************************************</p>

<p><b>MRV 5.7 (Aurora PTC) Changelog - 11th October 2011.</b></p>

<p><b>NOTES:</b></p>

<p>This does not contain a full changelog from the inception of MRV5, but will cover the basics. From this version onwards, we intend to keep an accurate record of changes and list them in a changelog that will be included with each release.</p> 

<p><b>CHANGES:</b></p> 

<p><b>New</b> - Implemented New Currency Options - USD, GBP and Euro for sales and payouts (site-wide).</p> 

<p><b>New</b> - Implemented PayPal Verification - Can click on the user PayPal account name in 'Requests' (Admin) and link directly to PayPal's Verification facility (Must be logged into your PP account).</p>

<p><b>New</b> - Replaced/streamlined Cron Jobs - Now only 2 required instead of previous 6.</p> 

<p><b>New</b> - Users can no longer click on their own ads.</p> 

<p><b>Fixed</b> - incorrect filename in template/layout.php (sexy-captcha file reference).</p> 

<p><b>Fixed</b> - quantity of 'Buys' not displaying in Admin Area 'Specials'.</p> 

<p><b>Fixed</b> - purging of ALL ad types when using 'Purge Ads' in 'Paid to Click' Manager.</p>

<p><b>Clarified</b> - some comments in Admin>Settings>Site Settings</p>

<p><b>Fixed</b> - Various other typos and minor bug fixes.</p>

<p><b>New</b> - Implemented Changelog.</p>

<p><b>New</b> - Created comprehensive Install and Upgrade Readme files.</p>

<p>

</body>
</html>
