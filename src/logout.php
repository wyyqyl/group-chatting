
<?php 
	include_once 'database.php';
	session_start();
	if(isset($_SESSION['id']))
	{
		
	
			$userid = $_SESSION['id'];
			
			sql_deleteOnlineusers($userid);
			
			session_destroy();
			
			header("location:LoginPage1.php");
	
	}
	else
	{
		$userid = $_SESSION['id'];
		echo $userid;
		echo "failed";
	
	}
	

?>