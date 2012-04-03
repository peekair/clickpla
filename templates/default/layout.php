<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title><?php echo $settings['site_title'] ." :: ". $includes['title']; ?></title> 
  <meta name="keywords" content="paid to click, earn cash"> 
  <meta http-equiv="X-UA-Compatible" content="IE=8" />
  <meta name="Description" content="Get Paid To Click!"> 
  <meta name="ROBOTS" content="ALL"> 
  <meta name="distribution" content="global">
  <meta http-equiv=Content-Type content="text/html; charset=windows-1252"> 
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <html xmlns="http://www.w3.org/1999/xhtml">
<!--
<link rel="stylesheet" type="text/css" href="templates/default/components.css">
<link rel="stylesheet" type="text/css" href="includes/ajax/components.css">
<link rel="stylesheet" type="text/css" href="templates/default/style.css">
-->
<link rel="stylesheet" type="text/css" href="css/default.css">

<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="/js/default.js"></script>
<script type="text/javascript" src="/js/jquery.sexy-captcha-0.1.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/css/sexy-captcha/captcha.css" />

</head>
<div id="adHitz"></div>

<div id="header">
  <div class="head">    
    <div class="inner clearfix">
      <div class="logo"><img src="images/logo.png" alt="daily-clicks.info" /></div>
      <div id="bannerTop">
        <span class="banner468x60"><? echo $pagebanner648; ?></span>
      </div>
    </div>
  </div>
  <div id="navigation">
    <div class="inner clearfix">
      <ul class="navigation">
        <li><a href="index.php?view=home&amp;<? echo $url_variables; ?>">Home</a>|</li>
        <li><a href="index.php?view=prices&amp;<? echo $url_variables; ?>">Purchase</a>|</li>
        <li><a href="index.php?view=click&<? echo $url_variables; ?>">View Ads</a>|</li>
        <? if(!$LOGGED_IN) { ?>
        <li><a href="index.php?view=join&<? echo $url_variables; ?>">Register</a>|</li>
        <li><a href="index.php?view=login&<? echo $url_variables; ?>">Login</a>|</li>
        <? }else{ ?>
        <li><a href="index.php?view=account&ac=profile&amp;<? echo $url_variables; ?>">Account</a>|</li>
        <li><a href="index.php?view=account&ac=forumindex&<? echo $url_variables; ?>">Forum</a>|</li>
        <li><a href="logout.php?<? echo $url_variables; ?>">Logout</a>|</li>
        <? } ?>
        <li><a  href="index.php?view=proof&amp;<?php echo $url_variables; ?>" title="Payment Proof">Payments</a></li>
      </ul>
    </div>
  </div>
  <div class="statistics">
    <div class="inner">
      <ul class="ticker inline">
          <li>We have <? echo number_format($totalmembers[total]); ?> Members</li>
          <li><? echo number_format($todaystats[new_members]); ?> New Today</li>
          <li><? echo number_format($todaystats[hits]); ?> Hits Today</li>
          <li>$<? echo number_format(round($totalpaid[total],2)); ?> Total Paid</li>
          <li><? echo number_format($total_online); ?> Online Now</li>
      </ul>    
    </div>
  </div>
</div>


<div class="page">

  <div id="main" class="clearfix">

    <p class="header_below"></p>


    <div id="content">
        <? if($LOGGED_IN) { ?>
        <div id="memberHeader">
          <span id="mh_welcome">Welcome Back! <span><? echo $thismemberinfo['username']; ?></span></span>
          <span id="mh_links">
            <ul class="inline">
              <li class="first"><a href="index.php?view=account&ac=profile&amp;<? echo $url_variables; ?>">My Account</a>|</li>
              <li><a href="index.php?view=account&ac=earn&amp;<? echo $url_variables; ?>">My Earnings</a>|</li>
              <li><a href="logout.php?<? echo $url_variables; ?>">Logout</a></li>
            </ul>
          </span>
        </div>
        <? } ?>

        <div class="contentBox feature">
          <h2>Featured Banners</h2>
          <div class="inner">
            <div class="content">
              <? if($areacontent != "") echo $areacontent; ?>
            </div>
          </div>
        </div>


        <? echo get_content($includes['title'],$includes[content]); ?>



        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
          <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
          <a class="addthis_button_tweet"></a>
          <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
          <a class="addthis_counter addthis_pill_style"></a>
        </div>
        <!-- AddThis Button END -->

        <div class='bottomContent'><?$pagebanner648 = get_banner();?><? echo $pagebanner648; ?>   </div>

    </div>

    <div id="sidebar">

        <div class="contentBox">
          <h2>Latest News</h2>
          <div class="inner">        
            <div class="content">

              <?
                $characters_to_display = "150"; //Change to how many characters you want to be displayd
                $sql=$Db1->query("SELECT * FROM news ORDER BY dsub DESC limit 1");
                $lastnews=$Db1->fetch_array($sql); 
                if(strlen($lastnews['news'] ) >= $characetrs_to_display)
                {
                  $news = substr($lastnews['news'],0,$characters_to_display)."..";
                }else{
                  $news = $lastnews['news']."...";
                }
                $news .= "<a href='index.php?view=news&$url_variables'><font color=\"#05409E\"> Read more...</font></a>";
                ?>
                <div behavior="scroll" direction="up" scrollamount="2" scrolldelay="1" onmouseover="this.stop()" onmouseout="this.start()">
                  <p><? echo $news; ?></p>
                </div>



            </div>
          </div>
        </div>


      <div class="sidebarContent" style="padding-top:0px; margin-bottom:0px;">
        <div class="fLinks">
          <? if($settings[flink_style]==2) echo get_content("Featured Links","$flinklist<p class=\"fLinkDefault\"> <a href=\"$settings[flinkdefaulturl]\">$settings[flinkdefault]</a></p>"); ?>
        </div>
      </div>
      <div class="sidebarContent1">

        <? echo get_content("Featured Ads","$fadslist"); ?>

      </div>
    </div>

<!--
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f6f11b232bdfb17"></script>
-->


<!--     <div class='topBanner clear'><?$pagebanner648 = get_banner();?><? echo $pagebanner648; ?>   </div>  -->



  </div>


</div>

<div id="footer">
  <div class="footerLinks">
    <ul class="inline">
      <li><a href="index.php?view=terms&amp;<? echo $url_variables; ?>">Terms</a></li>
      <li>|<a class='main_menu' href="index.php?view=proof&amp;<?php echo $url_variables; ?>" title="Payment Proof">Paid</a></li>
      <li>|<a href="index.php?view=help&amp;<? echo $url_variables; ?>">Help</a></li>
      <? if($LOGGED_IN) { ?>
      <li>|<a href="index.php?view=account&ac=contact&amp;<? echo $url_variables; ?>">Contact</a></li>
      <? } ?> <? echo iif($permission == 7,"<li>|<a href=\"admin.php?".$url_variables."\">Admin</span></a></li>"); ?>
    </ul>
  </div>
  <div class="copyright">Copyright &copy; 2012 Click-Planet. ALL RIGHTS RESERVED. <!-- Script & Design By: -->
  </div>
</div>

<div class="bottomBanner">
  <span>
    <?$pagebanner648 = get_banner();?>
    <? echo $pagebanner648; ?>        
  </span> 

  <span>
    <?$pagebanner648 = get_banner();?>
    <? echo $pagebanner648; ?>       
  </span> 

</div> 


</div>

</body>
<div class="adHitz">
<script type="text/javascript" src="http://adhitzads.com/422683"></script><script type="text/javascript" src="http://adhitzads.com/422765"></script>
</div>

</html>