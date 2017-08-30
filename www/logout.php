<?php
include_once('/var/www/config.php');
if (!$_REQUEST['src'])
	{
	if ($_SERVER['HTTP_X_FORWARDED_FOR']) 
		{ 
			$src = sprintf("%u",ip2long($_SERVER['HTTP_X_FORWARDED_FOR'])); 
		} else {
			$src = sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
		}
	} else {
	$src = $_REQUEST['src'];
	};
	
$list = split("\n",file_get_contents($checkfile));
	foreach ($list as $item) {
		list($longip,$lastaccess) = split(" ",$item,2);
		$difftime = $now - $lastaccess;
		if (($difftime > $timeout) or ($src == $longip)) {
			/*no action if match */
			} else {
			$writestring = $writestring.$longip.' '.$lastaccess."\n";
			}
		}
file_put_contents($checkfile,$writestring);
printf("%s has been successfully logged out.\n<br /> You can close your browser now.\n",long2ip($src));
?>