
<html>
<a href="logout.php">Logout</a>
</html>
<?php 
	

	session_start();  
	if(isset($_SESSION['id']))
	{
		
		header("location:storeOnlineUsers.php");
	
	}
	else
	{
		header("location:LoginPage1.php");
	
	}

?>

