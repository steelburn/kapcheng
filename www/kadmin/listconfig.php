<?php
include_once('config.php');

if ($_POST['rules']) { 
	if (file_put_contents($rulefile,$_POST['rules'])) {
		echo "Rules updated. Please reload configuration for the updates to take effect.";
		}
	};

$rules = file_get_contents($rulefile);
echo "<form method='post' action=''>kapcheng rules<br />\n";
echo "<textarea name='rules' cols='80' rows='15'>";
echo $rules;
echo "</textarea>\n<br />";
echo "<input type='submit' value='Update' />";
?>