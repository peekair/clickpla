<?
$includes[title]="Promotion";

$bannerlist=array(
	"http://www.$settings[domain_name]/banners/banner1.gif",
	"http://www.$settings[domain_name]/banners/banner2.gif",
	"http://www.$settings[domain_name]/banners/banner3.gif"
);

for($x=0; $x<count($bannerlist); $x++) {
	$thelist.="
<p class=\"refBanners\">
<img src=\"$bannerlist[$x]\"><br>
<i>$bannerlist[$x]</i><br>
<textarea rows=4 cols=55>&lt;a href=\"http://www.$settings[domain_name]/index.php?ref=$username\"&gt;&lt;img src=\"$bannerlist[$x]\" border=0&gt;&lt;/a&gt;</textarea>
</p>
";
}

$includes[content]="

<h3>Referral URLS</h3>
<ul>
	<li>Primary Homepage: <strong><a href=\"http://www.$settings[domain_name]/index.php?ref=$username\">http://www.$settings[domain_name]/index.php?ref=$username</a></strong></li>

</ul>

<h3>Promotional Banners</h3>
$thelist

";

?>
