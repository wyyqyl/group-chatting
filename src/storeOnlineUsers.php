<html>
<a href="logout.php">Logout</a> <br/>
</html>

<?php
		
	session_start();
	
	include_once 'database.php';
	
	$userid = $_SESSION['id'];
	
	$sql = "INSERT INTO onlineusers (uid) VALUES (" . $userid . ")";
	
			
		if(sql_execute($sql))
			{
				echo $userid."<br/>";
				echo "Successfully added";
				header("location:chat.php");
			}
		else 
			{
				echo $userid."<br/>";
				echo "failed";
				echo "bla";
			}	
		
?>


	
		
		
		
			
		
			
		
	
			
			
	