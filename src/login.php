<?php
if($_SERVER['HTTPS']!="on") {
	$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	header("Location:$redirect");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Sign In - G1T6 SECA</title>
		<link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
		<link type="text/css" href="css/style.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
		<script type="text/javascript" src="js/sha.js"></script>	
		<script type="text/javascript">
			$(function(){
				//Login UI Box
				$('#loginBox').tabs();
			});
			function hash(key){
				var shaObj = new jsSHA(key, "ASCII");
				var hash = shaObj.getHash("SHA-256", "HEX");
				return hash;
			}
			function check(){
				var key = document.getElementById("secretkey").value;
				document.getElementById("secretkey").value = hash(key);
				return true;
			}
		</script>				
	</head>
	<body>		
		<div id="dialog-confirm" title="Login Unsuccessful" style="display:none;">
			<p style="overflow:hidden"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="dText">An error has occurred. Please try again.</span></p>
		</div>	
		<?php
			error_reporting (E_ALL ^ E_NOTICE);
			$status = $_POST["status"]; 
			echo
			"
				<div id='jS' style='display:none;'>$status</div>
			";
		?>			
		<script type="text/javascript">
			if(document.getElementById('jS').innerHTML)
			{	
				if(document.getElementById('jS').innerHTML=="failed1")
				{										
					document.getElementById('dText').innerHTML='User credentials are incorrect.';					
				}
				else if(document.getElementById('jS').innerHTML=="failed2")
				{
					document.getElementById('dText').innerHTML='There is an error creating user session. Please try again.';
				}
				else if(document.getElementById('jS').innerHTML=="failed3")
				{
					document.getElementById('dText').innerHTML='There is an error registering user online status. Please try again.';
				}
				else if(document.getElementById('jS').innerHTML=="failed4")
				{
					document.getElementById('dText').innerHTML='Access Denied!<br>You are not authorized to enter chat for now.';
				}
				$( "#dialog-confirm" ).dialog({
					autoOpen: true,
					draggable: false,					
					resizable: false,
					height:170,
					modal: true,
					buttons: {						
						OK: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			}			
		</script>	
		<div id="header"><span>SECA - Sign In Here</span></div>		
		<!-- loginBox -->		
		<div id="loginBox" style="width:300px;height:150px;position:absolute;top:50%;margin-top:-75px;left:50%;margin-left:-150px;">
			<ul>
				<li><a href="#tabs-1">Sign In</a></li>				
			</ul>
			<div id="tabs-1">
				<form name="form1" method="post" action="processLogin.php" onSubmit="return check();">	
					<table>
						<tr>
							<td width="78">Username</td>
							<td width="6">:</td>
							<td width="294"><input type="text" name="username" value="" /></td>
						</tr>
						<tr>
							<td>Password</td>
							<td>:</td>
							<td><input type="password" name="password" value=""/></td>
						</tr>
						<tr>
							<td>Key</td>
							<td>:</td>
							<td><input id="secretkey" type="password" name="secretkey"  /></td>
						</tr>
					</table>							
					<input class="ui-state-default ui-corner-all" style="width:90px;height:25px;position:absolute;bottom:5px;right:10px;" type="submit" name="Submit" value="Sign In" />	
				</form>				
			</div>			
		</div>								
	</body>
</html>
