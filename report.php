<?
include("header.php");
if($userid != "") {$uid=$userid;}

echo"<html><head><title>Report A Site</title></head><body><center>";
if(isset($_POST['submit'])){
$adid=$_POST['adid'];
$sql=$Db1->query("SELECT * FROM reports WHERE adid='$adid'");
if($Db1->num_rows()==0){

$sql=$Db1->query("SELECT * FROM ads WHERE id='$adid'");
while($info=$Db1->fetch_array($sql)){

$title=$info['title'];
$target=$info['target'];
$placed_by=$info['username'];

}
$other=$_POST['other'];

$sql=$Db1->query("INSERT INTO reports 
	adid='$adid',
	username='$username',
	reason='$reason',
	other='$other',
	reports='1',
	title='$title',
	target='$target',
	placed_by='$placed_by',
	type='{$_GET['type']}'
	");

echo "Thank you for your report, we will look at the ad soon.<br \>
<a href=\"javascript:window.close();\">Close This Window</a>";
}else{
$info=$Db1->fetch_array($sql);
$users=explode(";",$info['username']);
if(in_array($username,$users)){
echo "You have already submitted a report for this site. We will review it as soon as possible. <br \>
<a href=\"javascript:window.close();\">Close This Window</a>";
}else{
$users=$info['username']."::".$username;
$reasons=$info['reason']."::".$reason;
$others=$info['other']."::".$other;
$reports=$info['reports']+1;
$sql=$Db1->query("UPDATE reports SET username='$users', reason='$reasons', other='$others', reports='$reports' WHERE adid='$adid'");

echo "Thank you for your report, we will look at the ad soon.<br \>
<a href=\"javascript:window.close();\">Close This Window</a>";

};
};
}else{

$sql=$Db1->query("SELECT * FROM reports WHERE adid='$id'");
$info=$Db1->fetch_array($sql);
$users=explode(";",$info['username']);
if(in_array($username,$users)){
echo "You have already submitted a report for this site.<br \>
<a href=\"javascript:window.close();\">Close This Window</a>";
}else{
echo"
<h4>Report a Site</h4>
<form action=\"report.php?{$url_variables}\" method=\"POST\">
<input type=\"hidden\" name=\"adid\" value=\"{$id}\">

Reason: <select name=\"reason\">
  <option value=\"Inappropriate Content\">Inappropriate Content</option>
  <option value=\"Frame Abuse\">Frame Abuse</option>
  <option value=\"Popup Abuse\">Popup Abuse</option>
  <option value=\"Virus/Spyware\">Virus/Spyware</option>
  <option value=\"Other\">Other (Please Specify)</option>
</select><br /><br />


Additional Information: <textarea name=\"other\" cols=\"50\" rows=\"6\">
</textarea>
<input name=\"submit\" type=\"submit\" value=\"Submit\"><input name=\"Reset\" type=\"reset\" value=\"Reset\">

</form>


";
};

};
echo "</center></body></html>";
?>