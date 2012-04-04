<?php

/****************************/
/*                          */
/*  DezendMe v1.0.28.01.12  */
/*  Qarizma, sidxx55, Cyko  */
/*  www.dezend.me           */
/*                          */
/****************************/

function pay_upline( $refered, $level, $oamount )
{
    global $Db1;
    global $username;
    global $settings;
    global $today_date;
    $return = 0;
    $sql = $Db1->query( "SELECT user.membership, memberships.downline_earns FROM user JOIN memberships ON memberships.id=user.membership WHERE user.username='{$refered}' and type='1'" );
    if ( 0 < $Db1->num_rows( ) )
    {
        $row = $Db1->fetch_array( $sql );
        $amount = $row[downline_earns] * $oamount;
    }
    else
    {
        $amount = $settings[upline_earnings] * $oamount;
    }
    if ( $level <= $settings['ref_levels'] && ( $username != $refered || $settings[allow_self_ref] == 1 ) )
    {
        if ( $level == 1 )
        {
            $Db1->query( "UPDATE user SET upline_earnings=upline_earnings+{$amount} WHERE username='{$username}' " );
        }
        $Db1->query( "UPDATE user SET balance=balance+".$amount.", last_act='".time( )."', referral_earns=referral_earns+".$amount." WHERE username='{$refered}'" );
        $Db1->query( "UPDATE stats SET cash=cash+".$amount." WHERE date='{$today_date}'" );
        $sql = $Db1->query( "SELECT refered FROM user WHERE username='{$refered}'" );
        $temp = $Db1->fetch_array( $sql );
        if ( isset( $temp[refered] ) )
        {
            $return = pay_upline( $temp[refered], $level + 1, $oamount );
        }
        return $return += $amount;
    }
    return $return;
}

function arrayValue( $array, $value )
{
    return $array[$value];
}

function isBadUrl( $src )
{
    global $badwords;
    $found = 0;
    foreach ( $badwords as $k )
    {
        $found += substr_count( $src, $k );
    }
    return $found;
}

function lookupIp( $ip )
{
    global $Db1;
    return $Db1->querySingle( "SELECT c.country FROM ip2nationCountries as c\r\n                    LEFT JOIN ip2nation as i ON c.code = i.country\r\n                    WHERE i.ip < INET_ATON('".mysql_real_escape_string( $ip )."')\r\n                    ORDER BY i.ip DESC\r\n                    LIMIT 1", "country" );
}

function load_template( $id )
{
    global $template_buffer;
    global $Db1;
    if ( $template_buffer[$id][0] != "" )
    {
        $return = $template_buffer[$id];
    }
    else
    {
        $sql = $Db1->query( "SELECT * FROM templates WHERE id='{$id}'" );
        $temp = $Db1->fetch_array( $sql );
        $template_buffer[$id] = $temp;
        $return = $template_buffer[$id][template];
    }
    return $return;
}

function show_help( $help )
{
    return "<a href=\"#\" onclick=\"return !showPopup('pbalance', event,'".htmlentities( $help )."');\" style=\"color: red;\"><small>?</small></a>";
}

function getGroupPerm( $usern, $perm )
{
    global $Db1;
    $sql = $Db1->query( "SELECT `group` FROM user WHERE username='{$usern}'" );
    $temp = $Db1->fetch_array( $sql );
    $Db1->query( "SELECT * FROM member_groups_perms WHERE perm='{$perm}' and `group`='".$temp[group]."'" );
    if ( 0 < $Db1->num_rows( ) )
    {
        return true;
    }
    return false;
}

function load_ajax( )
{
    return "\r\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"includes/ajax/ajaxtabs.css\" />\r\n\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"includes/ajax/components.css\" />\r\n\t\t<script type=\"text/javascript\" src=\"includes/ajax/prototype.js\"></script>\r\n\t\t<script type=\"text/javascript\" src=\"includes/ajax/jquery.js\"></script>\r\n\t\t<script type=\"text/javascript\" src=\"includes/ajax/ajaxtabs.js\"></script>\r\n\t\t<script type=\"text/javascript\" src=\"includes/ajax/ptsu_functions.js\"></script>\r\n\t\t<div id=\"returnOut\"></div>\r\n\t\t<div style=\"float: right; display: none;\" id=\"loading_alert\"><tt style=\"color: gray\">Loading</tt> <img src='images/loading.gif'/></div>";
}

function is_ad_blocked( $url )
{
    global $Db1;
    $sql = $Db1->query( "SELECT * FROM ad_block" );
    $found = 0;
    while ( $temp = $Db1->fetch_array( $sql ) )
    {
        $found += substr_count( $url, $temp[ad] );
    }
    return $found;
}

function is_account_approved( $account )
{
    global $Db1;
    $Db1->query( "SELECT * FROM payment_approve WHERE account='{$account}'" );
    return $Db1->num_rows( );
}

function is_account_blocked( $account )
{
    global $Db1;
    $found = 0;
    $sql = $Db1->query( "SELECT * FROM payment_block" );
    while ( $temp = $Db1->fetch_array( $sql ) )
    {
        $found += substr_count( $account, $temp[account] );
    }
    $found += is_email_blocked( $account );
    return $found;
}

function is_email_blocked( $account )
{
    global $Db1;
    $found = 0;
    $sql = $Db1->query( "SELECT * FROM email_block" );
    while ( $temp = $Db1->fetch_array( $sql ) )
    {
        $found += substr_count( $account, $temp[account] );
    }
    return $found;
}

function get_db_refid( $id )
{
    global $Db1;
    global $thismemberinfo;
    $return = false;
    $sql = $Db1->query( "SELECT db FROM user WHERE username='{$thismemberinfo['refered']}'" );
    if ( $Db1->num_rows( ) != 0 )
    {
        $temp = $Db1->fetch_array( $sql );
        $temp2 = explode( "^^", $temp[db] );
        $x = 0;
        while ( $x < count( $temp2 ) )
        {
            $temp3 = explode( "::", $temp2[$x] );
            if ( $temp3[0] == $id && $temp3[1] != "" )
            {
                $return = $temp3[1];
            }
            ++$x;
        }
    }
    if ( $return == false )
    {
        $sql = $Db1->query( "SELECT * FROM downline_builder WHERE id='{$id}'" );
        $temp = $Db1->fetch_array( $sql );
        $return = $temp[defaultid];
    }
    return $return;
}

function get_user_db_refid( $id )
{
    global $Db1;
    global $thismemberinfo;
    $return = false;
    $sql = $Db1->query( "SELECT db FROM user WHERE username='{$thismemberinfo['username']}'" );
    if ( $Db1->num_rows( ) != 0 )
    {
        $temp = $Db1->fetch_array( $sql );
        $temp2 = explode( "^^", $temp[db] );
        $x = 0;
        while ( $x < count( $temp2 ) )
        {
            $temp3 = explode( "::", $temp2[$x] );
            if ( $temp3[0] == $id && $temp3[1] != "" )
            {
                $return = $temp3[1];
            }
            ++$x;
        }
    }
    return $return;
}

function Verify_Email_Address( $email_address )
{
    $at = strpos( $email_address, "@" );
    $dot = strrpos( $email_address, "." );
    if ( $at === false || $dot === false || $dot <= $at + 1 || $dot == 0 || $dot == strlen( $email_address ) - 1 )
    {
        return false;
    }
    $user_name = substr( $email_address, 0, $at );
    $domain_name = substr( $email_address, $at + 1, strlen( $email_address ) );
    if ( $user_name == "" || $domain_name == "" )
    {
        return false;
    }
    if ( strlen( $user_name ) == 0 || strlen( $domain_name ) == 0 )
    {
        return false;
    }
    return true;
}

function loadfile( $text )
{
    return stripslashes( base64_decode( $text ) );
}

function haultscript( )
{
    global $SCRIPTSETTINGS;
    global $thehost;
    echo "<b style=\"color:red\">This script has not been registered correctly!</b><br />Please contact your script supplier for more information.<br /><br />\r\n\tDomain Registered: {$SCRIPTSETTINGS['domain']}<br />\r\n\tDomain Host: {$thehost}\r\n    ";
    $subject = "Illeagal Site - {$thehost}";
    $body = "\r\nHello,\r\n\r\n\tDomain Host: {$thehost}\r\nThis is just a informational email as a courteousy.\r\nThanks,\r\nYour Friendly KeyGen Maker.\r\n\r\n";
    $to = "maderitescripts@gmail.com";
    $headers = "From: pirate@ptccenter.com\r\n"."X-Mailer: php";
    if ( mail( $to, $subject, $body, $headers ) )
    {
        echo "<p>Message sent!</p>";
    }
    else
    {
        echo "<p>Message delivery failed...</p>";
    }
    exit( );
}

function send_mail( $to = "", $to_name = "", $subject = "", $body = "", $from = "", $from_name = "" )
{
    global $settings;
    if ( $from == "" )
    {
        $from = $settings[email_from_address];
    }
    if ( $from_name == "" )
    {
        $from_name = $settings[email_from_name];
    }
    include_once( "includes/class.phpmailer.php" );
    $mail = new phpmailer( );
    $mail->Username = $settings[email_username];
    $mail->Password = $settings[email_password];
    $mail->Helo = $settings[email_helo];
    $mail->Host = $settings[email_host];
    $mail->Mailer = $settings[email_method];
    $mail->From = $from;
    $mail->SMTPAuth = true;
    $mail->FromName = $from_name;
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->AddAddress( $to, $to_name );
    if ( !$mail->Send( ) )
    {
        $return = 0;
    }
    else
    {
        $return = 1;
    }
    $mail->ClearAddresses( );
    return $return;
}

function send_act_email( $uname )
{
    global $Db1;
    global $settings;
    mt_srand( ( double )microtime( ) * 9999999 );
    $activate_id = mt_rand( 1, 10000 )."".time( );
    $sql = $Db1->query( "SELECT * FROM user WHERE username='{$uname}'" );
    $temp = $Db1->fetch_array( $sql );
    if ( $temp[verify_id] == "" && $temp[verified] == 0 )
    {
        $Db1->query( "UPDATE user SET\r\n\t\t\tverified='0',\r\n\t\t\tverify_id='{$activate_id}'\r\n\t\tWHERE username='{$uname}'" );
    }
    $sql = $Db1->query( "SELECT * FROM user WHERE username='{$uname}'" );
    $user = $Db1->fetch_array( $sql );
    if ( 0 < $Db1->num_rows( ) )
    {
        if ( $user[verified] == 0 )
        {
            $subject = "Please Activate Your Account At {$settings['domain_name']}!";
            $body = "\r\nHello {$user['username']},\r\n\r\nYou must verify your email address for account activation!\r\nPlease goto the following URL in your browser:\r\n{$settings['base_url']}/index.php?view=verify&id={$user['verify_id']}&user={$user['username']}&action=verify\r\n\r\nActivation ID: {$user['verify_id']}\r\nUsername: {$user['username']}\r\n\r\n-{$settings['domain_name']} Admin\r\n\r\n************************************************************\r\nYou are receiving this email because this email address was\r\nsupplied during registration at {$settings['domain_name']}. If you\r\ndid not register an account here, please contact us.\r\n************************************************************";
            $msg = send_mail( $user[email], $user[name], $subject, $body );
        }
        else
        {
            $msg = 2;
        }
    }
    else
    {
        $msg = 0;
    }
    return $msg;
}

function payment_requested_mail( $username )
{
    global $Db1;
    global $settings;
    mt_srand( ( double )microtime( ) * 9999999 );
    $activate_id = mt_rand( 1, 10000 )."".time( );
    $sql = $Db1->query( "SELECT * FROM user WHERE username='{$username}'" );
    $temp = $Db1->fetch_array( $sql );
    if ( $temp[verify_id] == "" && $temp[verified] == 0 )
    {
        $Db1->query( "UPDATE user SET\r\n\t\t\tverified='0',\r\n\t\t\tverify_id='{$activate_id}'\r\n\t\tWHERE username='{$username}'" );
    }
    $sql = $Db1->query( "SELECT * FROM user WHERE username='{$username}'" );
    $user = $Db1->fetch_array( $sql );
    if ( 0 < $Db1->num_rows( ) )
    {
        if ( $settings['payment_notifier'] == 1 )
        {
            $subject = "{$username} has requested payment at {$settings['domain_name']}!";
            $body = "\r\nHello Admin,\r\n\r\nOne of your users has just requested a payment in one if your sites\r\n\r\n\r\nUsername: {$user['username']}\r\n\r\n-{$settings['domain_name']} Admin\r\n\r\n************************************************************\r\nYou are receiving this email because u have enabled the\r\npayment notifier at {$settings['domain_name']}. If you\r\ndont want to recive this notifications, just login to your admin panel\r\nand disable it at member settings\r\n************************************************************";
            $msg = send_mail( $settings[notifier_email], $user[name], $subject, $body );
        }
        else
        {
            $msg = 2;
        }
    }
    else
    {
        $msg = 0;
    }
    return $msg;
}

function shiftDL( $from, $to )
{
    global $Db1;
    $Db1->query( "UPDATE user SET refered='{$to}' WHERE refered='{$from}'" );
    $sql = $Db1->query( "SELECT * FROM user WHERE username='{$from}'" );
    $user = $Db1->fetch_array( $sql );
    $Db1->query( "UPDATE user SET\r\n\t\treferrals1=referrals1+{$user['referrals1']},\r\n\t\treferrals2=referrals2+{$user['referrals2']},\r\n\t\treferrals3=referrals3+{$user['referrals3']},\r\n\t\treferrals4=referrals4+{$user['referrals4']},\r\n\t\treferrals5=referrals5+{$user['referrals5']}\r\n\tWHERE username='{$to}'" );
    $Db1->query( "UPDATE user SET\r\n\t\treferrals1=0,\r\n\t\treferrals2=0,\r\n\t\treferrals3=0,\r\n\t\treferrals4=0,\r\n\t\treferrals5=0\r\n\tWHERE username='{$from}'" );
}

function is_html( $string )
{
    $res = array( );
    preg_match_all( "/<(.*?)>/s", $string, $res );
    if ( $res[0][0] == "" )
    {
        return false;
    }
    return true;
}

function loadClickHistory( $username, $type )
{
    global $Db1;
    $sql = $Db1->query( "SELECT clicks FROM click_history WHERE username='{$username}' and type='{$type}' LIMIT 1" );
    if ( $Db1->num_rows( ) == 0 )
    {
        $sql = $Db1->query( "INSERT INTO click_history SET username='{$username}', type='{$type}'" );
    }
    $preclicked = $Db1->fetch_array( $sql );
    if ( $preclicked[clicks] == "" )
    {
        $preclicked[clicks] = ":";
    }
    return $preclicked[clicks];
}

function findclick( $preclicked, $id )
{
    $return = 0;
    $preclicked2 = explode( ":", $preclicked );
    $x = 0;
    while ( $x < count( $preclicked2 ) )
    {
        if ( $preclicked2[$x] == $id )
        {
            $return = 1;
        }
        ++$x;
    }
    return $return;
}

function advspecial( )
{
    if ( $settings[currency] == "\$" )
    {
        $cursym = "\$";
    }
    if ( $settings[currency] == "GBP" )
    {
        $cursym = "£";
    }
    if ( $settings[currency] == "EUR" )
    {
        $cursym = "€";
    }
    global $settings;
    global $url_variables;
    global $Db1;
    global $username;
    global $LOGGED_IN;
    $sql = $Db1->query( "SELECT * FROM specials WHERE active='1' and `show`='1' LIMIT 1" );
    $special = $Db1->fetch_array( $sql );
    if ( $Db1->num_rows( ) != 0 )
    {
        $feats = "";
        $sql2 = $Db1->query( "SELECT * FROM special_benefits WHERE special='{$special['id']}' ORDER BY amount" );
        while ( $temp = $Db1->fetch_array( $sql2 ) )
        {
            if ( $temp[type] == "referrals" )
            {
                $sql = $Db1->query( "SELECT userid FROM user WHERE refered='' ".iif( $LOGGED_IN == true, "and username!='{$username}'" )."" );
                $totalrefsavailable = $Db1->num_rows( );
                if ( $totalrefsavailable < $temp[amount] )
                {
                    $temp[amount] = $totalrefsavailable;
                }
            }
            if ( 0 < $temp[amount] )
            {
                if ( $settings[currency] == "\$" )
                {
                    $cursym = "\$";
                }
                if ( $settings[currency] == "GBP" )
                {
                    $cursym = "£";
                }
                if ( $settings[currency] == "EUR" )
                {
                    $cursym = "€";
                }
                if ( $settings[curcolor] )
                {
                    $curcolor = $settings[curcolor];
                }
                else
                {
                    $curcolor = black;
                }
                if ( $settings[specialcolor] )
                {
                    $specialcolor = $settings[specialcolor];
                }
                else
                {
                    $specialcolor = black;
                }
                $feats .= "<li>".$temp[amount]."  ".$temp[title]." ".iif( $temp[type] != "tickets", "(".iif( $temp[type] == "link_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 * ( $settings[base_price] * $settings[class_d_ratio] ) + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "xcredits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 * ( $settings[base_price] * $settings[x_ratio] ) + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "popup_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 * ( $settings[base_price] * $settings[popup_ratio] ) + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "ptr_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 * ( $settings[base_price] * $settings[ptr_ratio] ) + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "ptra_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 * ( $settings[base_price] * $settings[ptr_d_ratio] ) + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "ptsu_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] * $settings[ptsu_cost] + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "fad_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 / $settings[fad_ratio] * $settings[base_price] + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "banner_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 / $settings[banner_ratio] * $settings[base_price] + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "fbanner_credits", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] / 1000 / $settings[fbanner_ratio] * $settings[base_price] + $settings[buy_fee] )." Value
                		</b>
                	</small>" )."".iif( $temp[type] == "referrals", 
                	"<small>
                		<b>
                			{$cursym}".( $temp[amount] * $settings[referral_price] + $settings[buy_fee] )." Value
                		</b>
                	</small>" ).")" );
            }
        }
        $tpackages = explode( ",", $special[packages] );
        if ( $settings[currency] == "\$" )
        {
            $cursym = "\$";
        }
        if ( $settings[currency] == "GBP" )
        {
            $cursym = "£";
        }
        if ( $settings[currency] == "EUR" )
        {
            $cursym = "€";
        }
        return "<div class=\"advspecial\">
            <h2>{$special['title']}</h2>
                <ul>{$feats}</ul>
                <div class=\"buyNow\">
       	            <a href=\"index.php?view=account&ac=buywizard&step=2&samount=1&ptype=special&id={$special['id']}&".$url_variables."\" class=\"button\">Click Here To Buy Now For {$cursym}".$tpackages[0] * $special[price]."!</a>
                </div>
        </div>";
    }
    return false;
}

function parse_link( $title, $l = 50 )
{
    $title = strip_tags( $title );
    $length = strlen( $title );
    if ( $l < $length )
    {
        return substr( $title, 0, $l )."...";
    }
    return $title;
}

function get_ad_button( $title, $url )
{
    global $adtype;
    global $url_variables;
    return "\r\n\t<td width=5></td>\r\n\t<td>\r\n\t\t".iif( $url == $adtype, "<b>", "<b><a href=\"index.php?view=account&ac=myads&adtype={$url}&".$url_variables."\">" )."{$title}".iif( $url == $adtype, "</b>", "</a>" )."\r\n\t</td>\r\n\t<td width=5></td>\r\n\t";
}

function randRoute( )
{
    srand( ( double )microtime( ) * 1000000 );
    $num = rand( 1, 9 );
    if ( $num == 7 || $num == 5 )
    {
        $num = randRoute( );
    }
    return $num;
}

function getrandRoute( )
{
    return randroute( ).randroute( ).randroute( ).randroute( );
}

function rand_string( $length )
{
    global $userid;
    $mtime = microtime( );
    $mtime = explode( " ", $mtime );
    $mtime = ( $mtime[1] * $mtime[0] * 10000 ).time( ) * substr( time( ), strlen( time( ) ) - 2, 2 );
    $mtime = base64_encode( $mtime );
    $mtime = base64_encode( $mtime );
    $mtime = $userid.str_replace( "=", "", $mtime );
    return substr( $mtime, 0, $length );
}

function iif( $var1, $text = "", $else = "" )
{
    if ( $var1 )
    {
        return $text;
    }
    return $else;
}

function check_valid_price( $num )
{
    if ( !preg_match( "/^[1-9]{1}[0-9]{0,2}\$/", $num ) && !preg_match( "/^[0-9]{1}[0-9]{0,2}[.]{1}[0-9]{2}\$/", $num ) )
    {
        return false;
    }
    return true;
}

function cheat_check( $return, $id )
{
    global $settings;
    global $Db1;
    global $username;
    if ( $settings['cheat_check_perc'] == 0 )
    {
        return false;
    }
    $sql = $Db1->query( "SELECT cheat_check, last_cheat FROM user WHERE username='{$username}'" );
    $temp = $Db1->fetch_array( $sql );
    srand( time( ) );
    $num = rand( ) % 100;
    if ( $num < $settings['cheat_check_perc'] && $settings[min_cheat_int] < ( time( ) - $temp[last_cheat] ) / 60 )
    {
        $sql = $Db1->query( "UPDATE user SET cheat_check='1' WHERE username='{$username}'" );
        $temp[cheat_check] = 1;
    }
    if ( $temp[cheat_check] == 1 )
    {
        return true;
    }
    return false;
}

function cheat_check2( $return, $id )
{
    global $Db1;
    global $settings;
    global $username;
    if ( $settings['cheat_check_perc'] == 0 )
    {
        $Db1->query( "UPDATE user SET cheat_check='0'" );
        return false;
    }
    $sql = $Db1->query( "SELECT cheat_check FROM user WHERE username='{$username}'" );
    $temp = $Db1->fetch_array( $sql );
    if ( $temp[cheat_check] == 1 )
    {
        return true;
    }
    return false;
}

function processSignup( $id, $approve )
{
    global $Db1;
    global $today_date;
    global $settings;
    $sql = $Db1->query( "SELECT * FROM ptsu_log WHERE id='".$id."'" );
    $temp = $Db1->fetch_array( $sql );
    if ( $approve == 1 )
    {
        if ( 0 < $settings[tickets_ptsu] )
        {
            $queryextra = " tickets=tickets+{$settings['tickets_ptsu']}, ";
        }
        $Db1->query( "UPDATE ptsu_log SET status='1' WHERE id='".$id."'" );
        $Db1->query( "UPDATE user SET ".( $temp['class'] == "P" ? "points=points" : "balance=balance" )."+".$temp[pamount].", {$queryextra} ptsu_earnings=ptsu_earnings+".$temp[pamount].", ptsu_approved=ptsu_approved+1 WHERE username='".$temp[username]."'" );
        $Db1->query( "UPDATE ptsuads SET pending=pending-1, signups=signups+1, signups_today=signups_today+1 WHERE id='".$temp[ptsu_id]."'" );
        $Db1->query( "UPDATE stats SET signups=signups+1, cash=cash+".$temp[pamount]." WHERE date='{$today_date}'" );
    }
    if ( $approve == 2 )
    {
        $Db1->query( "UPDATE ptsu_log SET status='2' WHERE id='".$id."'" );
    }
    if ( $approve == 3 )
    {
        $Db1->query( "UPDATE user SET ptsu_denied=ptsu_denied+1 WHERE username='".$temp[username]."'" );
        $Db1->query( "UPDATE ptsu_log SET status='3' WHERE id='".$id."'" );
        $Db1->query( "UPDATE ptsuads SET pending=pending-1, credits=credits+1 WHERE id='".$temp[ptsu_id]."'" );
    }
}

function deleteUser( $id )
{
    global $Db1;
    $sql = $Db1->query( "SELECT * FROM user WHERE userid='{$id}'" );
    $userinfo = $Db1->fetch_array( $sql );
    if ( SETTING_PTC == true )
    {
        $Db1->query( "DELETE FROM ads WHERE username='{$userinfo['username']}'" );
    }
    if ( SETTING_PTR == true )
    {
        $Db1->query( "DELETE FROM emails WHERE username='{$userinfo['username']}'" );
    }
    if ( SETTING_PTRA == true )
    {
        $Db1->query( "DELETE FROM ptrads WHERE username='{$userinfo['username']}'" );
    }
    if ( SETTING_PTSU == true )
    {
        $Db1->query( "DELETE FROM ptsuads WHERE username='{$userinfo['username']}'" );
    }
    if ( SETTING_PTP == true )
    {
        $Db1->query( "DELETE FROM popups WHERE username='{$userinfo['username']}'" );
    }
    if ( SETTING_CE == true )
    {
        $Db1->query( "DELETE FROM xsites WHERE username='{$userinfo['username']}'" );
    }
    $Db1->query( "DELETE FROM banners WHERE username='{$userinfo['username']}'" );
    $Db1->query( "DELETE FROM fbanners WHERE username='{$userinfo['username']}'" );
    $Db1->query( "DELETE FROM fads WHERE username='{$userinfo['username']}'" );
    $Db1->query( "DELETE FROM flinks WHERE username='{$userinfo['username']}'" );
    $Db1->query( "UPDATE user SET refered='' WHERE refered='".$userinfo[username]."' " );
    $Db1->query( "UPDATE user SET notes='".$userinfo[notes]."\n---------------\nDeleted By Admin' WHERE userid='{$userinfo['userid']}'" );
    $Db1->query( "INSERT INTO user_deleted SELECT * FROM user WHERE userid='{$userinfo['userid']}'" );
    $Db1->query( "DELETE FROM user WHERE userid='{$userinfo['userid']}'" );
}

function targetCountryList( $co = "" )
{
    global $Db1;
    $sql = $Db1->query( "SELECT * FROM target_co ORDER BY country" );
    $list = "<option value=\"\">All Countries</option>";
    while ( $temp = $Db1->fetch_array( $sql ) )
    {
        $list .= "<option value=\"".$temp[country]."\"".iif( $co == $temp[country], " selected=\"selected\"" ).">".$temp[country]."</option>";
    }
    return $list;
}

function checkNewMsg( )
{
    global $Db1;
    global $username;
    global $url_variables;
    $Db1->query( "SELECT id FROM messages WHERE username='{$username}' and `read`=0" );
    if ( 0 < $Db1->num_rows( ) )
    {
        return "<div class=\"newMail\">You have unread messages in your inbox! <a href=\"index.php?view=account&ac=messages&".$url_variables."\">Goto Inbox</a></div>";
    }
    return "";
}

function logError( $error )
{
    global $vip;
    global $username;
    global $Db1;
    $Db1->query( "INSERT INTO error_log SET\r\n\t\tusername='{$username}',\r\n\t\terror='{$error}',\r\n\t\tdsub='".time( )."',\r\n\t\tip='{$vip}'\r\n\t" );
}

function creditUpline( $refered, $level, $oamount )
{
    global $Db1;
    global $ad;
    global $username;
    $return = 0;
    $sql = $Db1->query( "SELECT user.membership, memberships.downline_earns FROM user JOIN memberships ON memberships.id=user.membership WHERE user.username='{$refered}' and type='1'" );
    if ( 0 < $Db1->num_rows( ) )
    {
        $row = $Db1->fetch_array( $sql );
        $amount = $row[downline_earns] * $oamount;
    }
    else
    {
        $amount = $settings[upline_earnings] * $oamount;
    }
    if ( $level <= $settings['ref_levels'] && ( $username != $refered || $settings[allow_self_ref] == 1 ) )
    {
        $sql = $Db1->query( "UPDATE user SET xcredits=xcredits+".$amount.", last_act='".time( )."' WHERE username='{$refered}'" );
        $sql = $Db1->query( "SELECT refered FROM user WHERE username='{$refered}'" );
        $temp = $Db1->fetch_array( $sql );
        if ( isset( $temp[refered] ) )
        {
            $return = creditUpline( $temp[refered], $level + 1, $oamount );
        }
        return $return += $amount;
    }
}

$apsver = 5.6;
$badwords = array( "http", "@", "ftp", "https", ":", "./", "../", "/", "cgi", "php", ".", "tmp", "htaccess", "root", "//", "www" );
$template_buffer = array( );
if ( ini_get( "register_globals" ) == 0 )
{
    if ( is_array( $_GET ) )
    {
        extract( $_GET, EXTR_SKIP );
    }
    if ( is_array( $_POST ) )
    {
        extract( $_POST, EXTR_SKIP );
    }
    if ( is_array( $_SERVER ) )
    {
        extract( $_SERVER, EXTR_SKIP );
    }
    if ( is_array( $_ENV ) )
    {
        extract( $_ENV, EXTR_SKIP );
    }
    if ( is_array( $_COOKIE ) )
    {
        extract( $_COOKIE, EXTR_SKIP );
    }
    if ( is_array( $_FILES ) )
    {
        extract( $_FILES, EXTR_SKIP );
    }
    if ( is_array( $_REQUEST ) )
    {
        extract( $_REQUEST, EXTR_SKIP );
    }
    if ( is_array( $_SESSION ) )
    {
        extract( $_SESSION, EXTR_SKIP );
    }
}
?>
