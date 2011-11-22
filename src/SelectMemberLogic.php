<?php
	
	include_once 'database.php';	
	$result = sql_getUsers();	
	$name = "ceo";
	
	$db_name = "group_chatting";
	mysql_connect("localhost", "root", "") or die("cannot connect");
	mysql_select_db($db_name) or die("cannot select DB");
	
	
	while($row = mysql_fetch_array($result)){	
			if (strcasecmp($name, $row['username']) != 0){	
					
					$member =  $row['username'];
					 
				//	echo $member;					
				if (isset($_POST[$member])){	
					
					echo $_POST[$member];
					mysql_query("UPDATE membersinfo SET allow='1' WHERE username='$_POST[$member]'");
					
					
				}else{
					mysql_query("UPDATE membersinfo SET allow='0' WHERE username='$member'");
					
				} 	
				echo "
						<form action='SelectMemberUI.php' method='post' name='frm'>								
							<input type='hidden' name='status' value='Success1' />				
						</form>
						<script language='javaScript'>
							document.frm.submit();
						</script>		
					";		
			}
			
	}

?>


