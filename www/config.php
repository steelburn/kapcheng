<?php
$checkfile = '/var/www/authlist.txt';
$timeout = 360;	
$timeformat = "Ymd G:i:s";

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

?>