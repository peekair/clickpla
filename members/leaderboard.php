<?php
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
$includes[title]="Leader Board";
include('config.php');
$conn = @mysql_connect( "localhost", "$DBUser", "$DBPassword" )
or die( "Could not connect" );
$rs = @mysql_select_db( "$DBDatabase", $conn )
or die( "Could not select database" );

$sql = "select * from user ORDER BY lbref DESC Limit 15";



$rs = mysql_query( $sql, $conn )
or die( "could not execute sql query!a" );
$lista = "<div align=\"center\"><img src=\"admin2/includes/icons/app_options.gif\"><b>Top Referrer Leaders</b><br>";
$lista.= "<table border=\"2\" cellpadding=\"3\">";
$lista.= "<tr><th>User</th>";
$lista.= "<th>Referrals</th>";
$lista.= "<th>Premium</th></tr>";


while( $row = @mysql_fetch_array( $rs ) )
{
$lista .= "<tr>";
$lista .= "<td>".$row["username"]."</td>";
$lista .= "<td>".$row["lbref"]."</td>";
$lista .= "<td>".$row[type]."</td>";
$lista .= "</tr>";
}
$lista .= "</table>";



$includes[content]="
<center><small>1=premium / 0=Free<br></small><table border=\"0\" cellpadding=\"2\" cellspacing=\"2\">$lista
";
?>