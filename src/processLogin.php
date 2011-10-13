<html>
<a href="logout.php">Logout</a>
</html>
<?php
		include_once 'database.php';
		// username and password sent from form 
		$myusername = $_POST["myusername"]; 
		$mypassword = $_POST["mypassword"];
		
		// $db_name="group_chatting"; // Database name 
		$tbl_name="membersinfo"; // Table name
		
		
		$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
	
		
		$result = sql_execute($sql);
		
		$userid = mysql_fetch_assoc($result);
		
		
		// Mysql_num_row is counting table row
		$count = mysql_num_rows($result);
		// If result matched $myusername and $mypassword, table row must be 1 row
		
		if($count==1){
		session_start();
		
		// Register $myusername, $mypassword and redirect to file "login_success.php"
		$_SESSION['id'] = $userid['id'];
		
		//echo $userid['id'];
		header("location:login_success.php");
		}else{
		echo "Wrong Username or Password";
		}
?>