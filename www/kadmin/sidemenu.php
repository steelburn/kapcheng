<html>
<head>
<link rel='stylesheet' type='text/css' href='left.css' />
<link rel='stylesheet' type='text/css' href='style.css' />
<script> 
var rowsel = new Array();
function toggleview (id1,id2) {
		var obj1 = document.getElementById(id1);
		var obj2 = document.getElementById(id2);
		(obj1.className=="itemshown") ? obj1.className="itemhidden" : obj1.className="itemshown"; 
		(obj1.className=="itemshown") ? obj2.innerHTML="<img border='0' src='images/open.gif' alt='[&ndash;]'>" : obj2.innerHTML="<img border='0' src='images/closed.gif' alt='[+]'>"; 
	}
</script>
</head>
<body>

<div class='linkwithicon'><a href="javascript:toggleview('usermgmt','toggleusermgmt')" id='toggleusermgmt'><img border='0' src='images/closed.gif' alt='[+]'></a> 
<div class='aftericon'><a href="javascript:toggleview('usermgmt','toggleusermgmt')" id='toggleusermgmt'><font color=#000000>User/Group/IP Management</font></a></div></div> 
<div class='itemhidden' id='usermgmt'>
	<div class='linkindented'>Add/Modify/Delete</div>
	<div class='linkindented'>Set ACL</div>
</div>

<div class='linkwithicon'><a href="javascript:toggleview('features','togglefeatures')" id='togglefeatures'><img border='0' src='images/closed.gif' alt='[+]'></a> 
<div class='aftericon'><a href="javascript:toggleview('features','togglefeatures')" id='togglefeatures'><font color=#000000>Features</font></a></div></div> 
<div class='itemhidden' id='features'>
	<div class='linkindented'>Activate/Deactivate</div>
</div>

<div class='linkwithicon'><a href="javascript:toggleview('filtermgmt','togglefiltermgmt')" id='togglefiltermgmt'><img border='0' src='images/closed.gif' alt='[+]'></a> 
<div class='aftericon'><a href="javascript:toggleview('filtermgmt','togglefiltermgmt')" id='togglefiltermgmt'><font color=#000000>Filter Management</font></a></div></div> 
<div class='itemhidden' id='filtermgmt'>
	<div class='linkindented'><a href='listconfig.php' target='right'>Show/Edit/Delete rules</a></div>
</div>

<div class='linkwithicon'><a href="javascript:toggleview('captivemgmt','togglecaptivemgmt')" id='togglecaptivemgmt'><img border='0' src='images/closed.gif' alt='[+]'></a> 
<div class='aftericon'><a href="javascript:toggleview('captivemgmt','togglecaptivemgmt')" id='togglecaptivemgmt'><font color=#000000>Captive Portal Management</font></a></div></div> 
<div class='itemhidden' id='captivemgmt'>
	<div class='linkindented'><a href='listconfig.php' target='right'>User authentication</a></div>
	<div class='linkindented'><a href='listconfig.php' target='right'>Show/Edit/Delete rules</a></div>
</div>

<div class='linkwithicon'><a href="javascript:toggleview('logging','togglelogging')" id='togglelogging'><img border='0' src='images/closed.gif' alt='[+]'></a> 
<div class='aftericon'><a href="javascript:toggleview('logging','togglelogging')" id='togglelogging'><font color=#000000>Logging</font></a></div></div> 
<div class='itemhidden' id='logging'>
	<div class='linkindented'><a href='listconfig.php' target='right'>Logging configuration</a></div>
	<div class='linkindented'><a href='listconfig.php' target='right'>View logs</a></div>
</div>

<div class='linkwithicon'><a href="javascript:toggleview('system','togglesystem')" id='togglesystem'><img border='0' src='images/closed.gif' alt='[+]'></a> 
<div class='aftericon'><a href="javascript:toggleview('system','togglesystem')" id='togglesystem'><font color=#000000>System</font></a></div></div> 
<div class='itemhidden' id='system'>
	<div class='linkindented'><a href='listconfig.php' target='right'>Show configuration dump</a></div>
	<div class='linkindented'><a href='service/reload.php' target='right'>Reload configuration</a></div>
	<div class='linkindented'><a href='service/stop.php' target='right'>Stop server</a></div>
	<div class='linkindented'><a href='service/start.php' target='right'>Start server</a></div>
</div>
<div><font color=#000000><a href='logout.php'><strong>Logout</strong></a></font></div>

</body>
</html>
