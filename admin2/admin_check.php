<center>

<br>
<br>
<table <?php echo $table; ?>>
<tr>
<td colspan='2' <?php echo $header; ?>>
    GeoIP Checks
</td>
</tr>

<tr>
<td align='center'>
    Check accounts with blank country<br>
    info and try to detect their country.<hr>
    <form style='margin:0px' method='POST' action='<?php echo $_SERVER['PHP_SELF']."?".$get_variables;?>'>
    <input type='hidden' name='action' value='blank'>
    <input type='hidden' name='function' value='admin_check'>
    <input type='checkbox' checked name='show_results'> Show results, 
    <input type='submit' value='Go!'>
    </form>
</td>
<td align='center'>
    Check all accounts and<br>
    update their countries.<hr>
    <form style='margin:0px' method='POST' action='<?php echo $_SERVER['PHP_SELF']."?".$get_variables;?>'>
    <input type='hidden' name='action' value='all'>
    <input type='hidden' name='function' value='admin_check'>
    <input type='checkbox' checked name='show_results'> Show results, 
    <input type='submit' value='Go!'>
    </form>
</td>
</tr>
</table>
</center>
<br>

<?php
$check = false;
//-----------------------------------------
// Did admin want a country check?
//-----------------------------------------
if($_POST['action'] == 'blank')
{
    $query = mysql_query("SELECT username, last_ip, country FROM `user` WHERE country = ''");
    $check = true;
}
if($_POST['action'] == 'all')
{
    $query = mysql_query("SELECT username, last_ip, country FROM `user` WHERE 1");
    $check = true;
}

//-----------------------------------------
// Perform country check
//-----------------------------------------
if($check)
{
    
    if (!file_exists("admin2/$admin_folder/geoip.inc.php"))
    {
        echo "Geoip include file:<br><b>admin2/$admin_folder/geoip.inc.php</b><br>does not exist, please install GeoIP database. Aborting check...";
        exit;
    }   

    if (!file_exists("admin2/$admin_folder/GeoIP.dat"))
    {
        echo "Geoip database file:<br><b>admin2/$admin_folder/GeoIP.dat'</b><br>does not exist, please install GeoIP database. Aborting check...";
        exit;
    }

    //---------------------------
    // Include GeoIP?
    //---------------------------
    if(!function_exists('geoip_open'))
    {
        include("admin2/$admin_folder/geoip.inc.php");
    }
    $gi = geoip_open("admin2/$admin_folder/GeoIP.dat",GEOIP_STANDARD);

    //---------------------------
    // Loop thru users
    //---------------------------
    echo "<table border='0' cellpadding='3' cellspacing='0'>\n";
    echo "<tr><td colspan='4'>Performing check...<hr></td></tr>\n";
    echo "<tr><td>Username</td><td>IP</td><td>New Country</td><td>Prev. Country</td></tr>\n";
    while(list($username, $ip, $country) = mysql_fetch_array($query))
    {
        $ip_country = geoip_country_name_by_addr($gi, $ip);
        if($_POST['show_results'])
        {
            if(empty($country))
                $country = '<i>{blank}</i>';
            echo "<tr><td><b>$username</b></td><td>$ip</td><td>$ip_country</td><td>$country</td></tr>\n";
        }
        if(!empty($ip_country))
            mysql_query("UPDATE user SET country = '".mysql_real_escape_string($ip_country)."' WHERE username = '".mysql_real_escape_string($username)."'");
    }
    if(mysql_num_rows($query) == 0 AND $_POST['show_results'])
    {
        echo "<tr><td colspan='4'><b>-- No users found --</b></td></tr>\n";
    }
    if(!$_POST['show_results'])echo "<tr><td colspan='4'><b>-- output disabled --</td></tr>\n";
    echo "<tr><td colspan='4'><hr>Done! ".mysql_num_rows($query)." accounts updated<br></td></tr></table>\n";
}
?>












