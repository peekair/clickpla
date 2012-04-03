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
//**S**//
//$view=$_GET[view];
//$ac=$_GET[ac];

if($view == "") {
	$view="home";
}
//	1:Must be logged in to see
//	2:Must be logged out to see

$void=0;
$void = isBadUrl($view) + isBadUrl($ac);


if($void > 0) {
send_mail($settings[admin_email],"Site Admin","Hack Attempt At $settings[site_title]","
View Variable: $view
Ac Variable: $ac
Ip Address: $vip
Member: $username");
	echo "error";
	$Db1->sql_close();
	exit;
}

if($void == 0) {


$module['home']			=		array("Welcome To $settings[site_title]!","templates/$settings[template]/home.php",0);
$module['news']			=		array("News And Announcements","news.php",0);
$module['advertise']	=		array("Advertisers","advertise.php",0);
$module['affiliates']	=		array("Affiliates","affiliates.php",0);
$module['click']		=		array("Log In","members/click.php",0);
$module['site_info']		=		array("Site Info","site_info.php",0);
$module['key']		=		array("KEY","key.php",0);
$module['howmuch']		=		array("From where are our members","howmuch.php",0);
$module['shame']		=		array("Hall Of Shame","shame.php",0);
$module['thankyou']		=		array("Thank You!","thankyou.php",0);

$module['about']		=		array("About Us!","aboutus.php",0);

$module['ptp']			=		array("Paid To Promote","ptp.php",0);
$module['page']			=		array("","page.php",0);
$module['buyreferrals']			=		array("","buyreferrals.php",0);
$module['polls']			=		array("Polls","polls.php",0);

$module['faqs']			=		array("Affilate FAQs","faq.php",0);


$module['stats']			=		array("Site Stats","stats.php",0);


$module['verify_purchase']	=		array("","verify_purchase.php",0);

$module['proof']	=		array("","proof.php",0);


$module['update_email']	=		array("Update Your Email Address","update_email.php",0);
$module['verify']		=		array("Verify Your Email","verify.php",0);
$module['resend_act']	=		array("Resend Activation Email","resend_act.php",0);


$module['memberships']	=		array("Memberships Information","memberships.php",0);
$module['specials']		=		array("Specials Information","specials.php",0);

$module['prices']		=		array("Prices","prices.php",0);

$module['testimonials']	=		array("Testimonials","testimonials.php",0);

$module['terms']		=		array("Terms","terms.php",0);
$module['privacy']		=		array("Privacy","privacy.php",0);

$module['help']			=		array("Help!","help.php",0);

$module['login']		=		array("Log In","members/login.php",0);
$module['join']			=		array("Join","members/join.php",0);

$module['welcome']		=		array("Welcome $uname!","welcome.php",0);

$module['contact']		=		array("Contact","contact.php",0);
$module['not_found']	=		array("Page Not Found!","errors/404.php",0);

$module['account']		=		array("Account","members/account.php",1);

$module['lostpwd']		=		array("Password Retreival","members/lostpwd.php",0);

$module['lostpin']		=		array("Request Personal Pin","members/lostpin.php",0);
$module['no_perm']		=		array("Access Denied!","admin2/no_perm.php",0);
$module['admin']		=		array("Admin Panel!","admin2/admin.php",7);

$thePermission=7;

if(($LOGGED_IN == false) && ($module[$view][2] == 1)) {
	$returnTo=$view;
	$view="login";
}

if((($permission != 7) && ($permission != 6)) && ($module[$view][2] == 7)) {
	$view="no_perm";
}


if($ac == "") $ac="mrpanel";

$splitview = explode("/",$view);


if(!$module[$view][1]) {
//	$view = "source/{$view}";
	$filename = "./source/{$splitview[0]}.php";
}
else {
	$includes[title]=$module[$view][0];
	$filename = "./".$module[$view][1];
}


if(!is_file($filename)) {
	$view="not_found";
	$filename=$module[$view][1];
}
else {
    ob_start();
    include $filename;
    $pageOutput = ob_get_contents();
    ob_end_clean();
    $includes[content].=$pageOutput;
}

if(($module[$view][2] == 7) && ($thePermission>$permission)) {
	exit;
}
}
//**E**//
?>