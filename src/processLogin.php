<html>
<a href="logout.php">Logout</a>
</html>
<?php
include_once('database.php');
// username and password sent from form

foreach($_POST as $key => $value)
{
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	$$key = mysql_real_escape_string($value);
}

$table = "membersinfo";
$sql = "SELECT * FROM $table WHERE username = '$username'";
$user = sql_getdata($sql);
if($user['allow'] == 1){
	$hash = hash_hmac('sha512', $password, $user['salt']);
	if($hash == $user['password']){
		session_start();
	
		// Register $myusername, $mypassword and redirect to file "login_success.php"
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $username;
		$_SESSION['key'] = $secretkey;
		header("location:login_success.php");
	}else{
		echo "
					<form action='login.php' method='post' name='frm'>								
						<input type='hidden' name='status' value='failed1' />				
					</form>
					<script language='javaScript'>
						document.frm.submit();
					</script>		
				";		
	}
}else{
		echo "
					<form action='login.php' method='post' name='frm'>								
						<input type='hidden' name='status' value='failed4' />				
					</form>
					<script language='javaScript'>
						document.frm.submit();
					</script>		
				";	
}

?>