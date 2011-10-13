<?php
		// username and password sent from form 
		//$myusername = $_POST["Jerome"];
		$myusername = 'Jerome';
		//$mypassword = sha1($_POST["apple"]);
		$mypassword = sha1('apple');
		




		
		 
		$tbl_name="membersinfo"; // Table name
		
		// Connect to server and select databse.
		
		include('database.php');
		
		
		
		// To protect MySQL injection (more detail about MySQL injection)
		
		//$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
		
		//$sql="INSERT INTO $tbl_name VALUES (3,'Jerome', 'apple')";
		$sql="INSERT INTO $tbl_name (username, password) VALUES ('$myusername','$mypassword')";
		$result=sql_execute($sql);
		echo $result;
?>