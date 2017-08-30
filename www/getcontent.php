<?php
$url=$_REQUEST['url'];
$getcontent = file_get_contents($url);
echo $getcontent;
?>