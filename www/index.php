<?php $msg = $_REQUEST['msg']; ?>
<html>
	<head>
		<title><?php echo $msg ?></title>
		<style>
.boxcenter {
	background-color: #f0e78c;
	border: orange;
	font-family: sans-serif;
	outline-color: #cd853f;
	outline-style: solid;
	outline-width: thin;
	text-align: center;
	padding-left: 5%;
	padding-right: 5%;
	padding-top: 5%;
	padding-bottom: 5%;
	width: 3.75in;
	margin-left: 20%;
}
.contactadmin {
	background-color: #ffeb2f;
	font-family: sans-serif;
}
.msg {
	background-color: #6740e1;
	color: #f5f5dc;
	font-size: larger;
	text-align: center;
}
.spare {
	margin-top:20%;
	margin-left: 20%;
	margin-right: 20%;
}
		</style>
	</head>
<body class="spare">
	<div class="boxcenter">
		<div><img src='FreeWifi-Banner.png' /></div>
		<div class="msg"><?php echo $msg;?></div>
		<div class="contactadmin">
		Please contact respective network admin should you think this needs fixing. Thank you.
		</div>
	</div>
</body>
