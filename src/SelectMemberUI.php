<?php
	
	include_once 'database.php';	
	$result = sql_getUsers();	
	$name = "ceo";

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
			$(function(){			
				// Chat List
				$("#memList").accordion({ 
					'header': "h3"
				});			
			});			
		</script>				
	</head>
	<body>
	<div id="dialog-confirm" title="Status" style="display:none;">
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
				if(document.getElementById('jS').innerHTML=="Success1")
				{										
					document.getElementById('dText').innerHTML='Members are successfully selected for upcoming conference';					
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
	<div id="header"><span>SECA - Choose members</span></div>	
	<div id="bodyContainer">
			<div id="memBox" style="width:300px;height:450px;position:absolute;top:50%;margin-top:-150px;left:50%;margin-left:-150px;">	
		<div id="memList"
			style="width: 100%; height: 275px; position: absolute; top: 0px; left: 0px;overflow:auto;">
			<div>	
					<form action="SelectMemberLogic.php" method="post">
				<h3>
				<a href="#">Members</a>
				</h3>
				<span style="padding: 0px; margin: 0px; height: 450px;">
					<span id="ssUsers" style="visible:none;"></span>
					<ol id="availMembers">					

		<?php 				
				while($row = mysql_fetch_array($result)){	
					if (strcasecmp($name, $row['username']) != 0){
							
						?>
			  <li><input type="checkbox" name="<?php echo $row['username'];?>" value="<?php echo $row['username'];?>"/><?php echo $row['username'];?></li><br/>		 	
				<?php		} }?> 
					</ol><br><br>					
						<input class="ui-state-default ui-corner-all" style="width:90px;height:25px;position:absolute;bottom:5px;right:30px;" type="submit" name="Submit" value="Submit" />
								
				</span>
			
					</form>
			</div>
		</div>	
					 
	</div>

	</div>
		
	</body>
</html>