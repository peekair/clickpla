<?

include("config.php");
include("includes/functions.php");
include("includes/globals.php");
//**S**//
setcookie("c_sid", $sid,time()+360000);
setcookie("c_sid2", $sid2,time()+360000);
setcookie("c_siduid", $siduid,time()+360000);


//header("Location: index.php?".iif(isset($returnTo),"view=$returnTo","view=account&ac=main")."".iif("$id","&id=$id").iif($ptype,"&ptype=$ptype").iif($step,"&step=$step")."".iif(isset($ac),"&ac=$ac")."&sid=$sid&sid2=$sid2&siduid=$siduid");
header("Location: $settings[login_redirect]"."sid=$sid&sid2=$sid2&siduid=$siduid");
//header("Location: index.php?view=account&ac=mygpt&sid=$sid&sid2=$sid2&siduid=$siduid");
//**E**//
?>