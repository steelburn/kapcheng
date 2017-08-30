<?php
include_once('/var/www/config.php');

$msg = $_REQUEST['msg'];
$url = $_REQUEST['url'];
$now = time();

$listcontent = file_get_contents($checkfile);
if (strpos($listcontent,$src)===false) {
	$fpointer = fopen($checkfile,'a');
	fprintf($fpointer,"%s %d\n",$src,$now);
	fclose($fpointer);
	};
echo "<html><head><title>blogspaper.org :: Free WiFi Service</title><style> body { font-family: sans-serif; }</style></head><body>";
echo "<img src='http://www.blogspaper.org/wp-content/uploads/2009/03/freewifi-banner.png' />";
echo "<br />";
echo "To continue browsing, please click <a href='$url'>here.</a><br />";
echo "</body>";
?>