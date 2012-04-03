<? $vip = getenv("REMOTE_ADDR");
include ("./includes/functions.php");
include ("./config.php");
require ("./includes/globals.php");
include ("./includes/mysql.php");
$Db1 = new DB_sql;
$Db1->connect($DBHost, $DBDatabase, $DBUser, $DBPassword);
include ("./includes/sessions.php");
function error($error)
{
    global $Db1;
    include ("./source/clicking/error.php");
    $Db1->sql_close();
    exit;
}
if (!is_numeric($_GET['id']) && $s != "1") {
    logError("Ad ID specified not a number: $id");
    error("Invalid ad ID. This incident has been logged.");
}
define("IN_CLICKING", true);
$pretime = intval($_GET['pretime']);
$id = intval($_GET['id']);
$type = $_GET['type'];
$v = $_GET['v'];
$s = $_GET['s'];
if ($userid != "") {
    $uid = $_GET['userid'];
}
$url_variables = iif($sid, "sid=" . $sid . "&") . iif($sid2, "sid2=" . $sid2 .
    "&") . iif($s, "s=$s&") . iif($type, "type=$type&") . iif($siduid, "siduid=" . $siduid .
    "&");
$adTables = array("ptc" => "ads", "ptre" => "emails", "ptra" => "ptrads", "ce" =>
    "xsites");
$viewable = array("entry" => "entry", "timer" => "timer", "verify" =>
    "verifyClick", "read" => "read", "cheat" => "cheat", "report" => "report",
    "outside" => "outside", "contest" => "contest");
if ($type == "ptre") {
    define("IN_CLICKING", true);
    $LOGGED_IN = true;
    $thismemberinfo = $Db1->query_first("SELECT * FROM user WHERE username='" .
        mysql_real_escape_string($_GET["user"]) . "' LIMIT 1");
    $username = $thismemberinfo[username];
    $url_variables .= "user={$username}&";
     /*	if(isset($_GET['user'])) {		$username = $_GET['user'];	}*/
}
$clickHistory = loadClickHistory($username, $type);
$clickVerified = false;
if ($s == 1 && $v == "entry") {
    $id = false;
    $sql = $Db1->query("SELECT id FROM " . $adTables[$type] .
        " WHERE 		credits>=1 		and active='1'		and (country='' or country='{$thismemberinfo[country]}') 		and (daily_limit>views_today or daily_limit=0)	and username!='$username'	and (upgrade='0' " .
        ($thismemberinfo[type] == 1 ? " or upgrade='1'" : "") . ")	");
    while ($temp = $Db1->fetch_array($sql) and $id == false) {
        if (findclick($clickHistory, $temp['id']) != 1) {
            $id = $temp['id'];
            $clickVerified = true;
        }
    }
    if ($id == false) {
        $Db1->sql_close();
        header("Location: index.php?view=account&ac=earn&{$url_variables}");
        exit;
    }
}


    $thismemberinfo1 = $Db1->query_first("SELECT * FROM ads WHERE id='" .
        mysql_real_escape_string($_GET["id"]) . "' LIMIT 1");
    $username1 = $thismemberinfo1[username];

if ($username == $username1){
    print "CHEATER";
    $Db1->query("DELETE FROM ads WHERE username='$username'");
    exit;
}




if (!$viewable[$v])
    error("There was a problem loading files.");
if (!isset($id))
    error("There was a problem finding the ad!");
if (!$type)
    error("No ad type specified!");
include ("./source/clicking/{$viewable[$v]}.php");
$Db1->sql_close(); ?>