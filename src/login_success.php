<?php
session_start();
if(isset($_SESSION['id']))
{
	header("location:storeOnlineUsers.php");
}
else
{
	echo "<form action='login.php' method='post' name='frm'>								
			<input type='hidden' name='status' value='failed2' />				
		</form>
		<script language='javaScript'>
			document.frm.submit();
		</script>";	
}
?>