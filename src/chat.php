<!DOCTYPE html>
<html>
<?php
session_start();
	$_SESSION['id'];
?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Chat Window - G1T6 GESD-C</title>
		<link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
		<link type="text/css" href="css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>					
		<script type="text/javascript">
			$(function(){			
				// Chat List
				$("#chatList").accordion({ header: "h3" });			
				// Chat Log
				$('#chatLog').tabs();
				// Chat Box
				$('#chatBox').tabs();				
			});
		</script>				
	</head>
	<body>
		<div id="header"><span>SEC - Username</span></div>	
		<div id="bodyContainer">
			<!-- Chat List -->		
			<div id="chatList" style="width:20%;height:500px;position:absolute;top:0px;left:0px;">
				<div>
					<h3><a href="#">Marketing Meeting</a></h3>
					<div style="padding:0px;margin:0px;">
						<li>
							<ul>Steven Miller</ul>
							<ul>Ding Xuhua</ul>
							<ul>Li Yingjiu</ul>
						</li>
					</div>
				</div>			
				<div>
					<h3><a href="#">Minimize</a></h3>
				</div>				
			</div>	
			<!-- Chat Log -->	
			<div id="chatLog" style="width:78%;height:400px;position:absolute;top:0px;left:21%;">
				<ul>
					<li><a href="#tabs-1">Chat Log</a></li>				
				</ul>
				<div id="tabs-1">
					<span id="chatLog_Content">Chat Log goes here...</span>
				</div>			
			</div>
			<!-- Chat Box -->
			<form name = "chat" action = "handleMessage.php" method = "post">	
			<div id="chatBox" style="width:78%;height:95px;position:absolute;top:410px;left:21%;">
			
					<li><a href="#tabs-1">Chat Box</a></li>				
				</ul>
				<div id="tabs-1">
					<textarea name= "msg" cols = "110" rows = "3"></textarea>
					
					<input type = "Submit" value="Send"/>
				</div>			
			</div>
		
			</form>
		</div>
	</body>
</html>