<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sign In - G1T6 SEC</title>
		<link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
		<link type="text/css" href="css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>					
		<script type="text/javascript">
			$(function(){
				//Login UI Box
				$('#loginBox').tabs();
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
					buttons: {
						"Ok": function() { 
							$(this).dialog("close"); 
						}
					}
				});							
			});
		</script>				
	</head>
	<body>	
		<?php
			if($_GET["state"]="failed")
			{
				echo 
				"		
					<script type='text/javascript'>
						$('#dialog').dialog('open');
					</script>
				";			
			}
		?>
		<div id="header"><span>SEC - Sign In Here</span></div>
		<!-- loginBox -->		
		<div id="loginBox" style="width:300px;height:150px;position:absolute;top:50%;margin-top:-75px;left:50%;margin-left:-150px;">
			<ul>
				<li><a href="#tabs-1">Sign In</a></li>				
			</ul>
			<div id="tabs-1">
				<form name="form1" method="post" action="processLogin.php">	
					<table>
						<tr>
							<td width="78">Username</td>
							<td width="6">:</td>
							<td width="294"><input type="text" name="myusername" /></td>
						</tr>
						<tr>
							<td>Password</td>
							<td>:</td>
							<td><input type="text" name="mypassword" /></td>
						</tr>													
					</table>							
					<input class="ui-state-default ui-corner-all" style="width:90px;height:25px;position:absolute;bottom:10px;right:10px;" type="submit" name="Submit" value="Sign In" />										
				</form>				
			</div>							
		</div>				
		<div id="dialog" title="Login Unsuccessful">
					<p>Login Unsuccessful</p>
		</div>			
	</body>
</html>

