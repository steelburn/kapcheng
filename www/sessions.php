<?php
/* 
	kapcheng - Captive Portal Engine
	sessions.php - List active sessions
*/
include_once('/var/www/config.php');
$sessions = split("\n",file_get_contents($checkfile));
echo $sessions;
foreach ($sessions as $session) {
	list($longip,$timestamp) = split(" ",$session);
	echo "<pre>Active sessions\n";
	if (trim($longip)!="") 
		{
		echo long2ip($longip)." ".date($timeformat,$timestamp)."\n";
		}
	echo "</pre>";
	};
?>