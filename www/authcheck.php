<?php
include_once('/var/www/config.php');
error_reporting(0);

$auth = 0;
	
$list = split("\n",file_get_contents($checkfile));
foreach ($list as $item) {
	list($longip,$lastaccess) = split(" ",$item,2);
	if ($src == $longip) { 
		$now = time();
		$difftime = $now - $lastaccess;
		if ($difftime <= $timeout) { $auth = 1; } else { $auth = 2; };
		} 
	} 

if (($auth == 1) or ($auth == 2)) { 
	if ($auth == 1) { echo "Authenticated"; } else { echo "Timeout"; };
	$writestring = '';
	foreach ($list as $item) {
		list($longip,$lastaccess) = split(' ',$item,2);
		$difftime = $now - $lastaccess;
		if ($difftime <= $timeout) { 
			if ($src == $longip) {
				$lastaccess = $now;
				}
			$writestring = $writestring.$longip.' '.$lastaccess."\n";
			}
		}
	file_put_contents($checkfile,$writestring);
	} else { echo "Not authenticated";}

?>