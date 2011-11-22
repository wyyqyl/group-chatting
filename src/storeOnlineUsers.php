<?php
session_start();

include_once 'database.php';

$userid = $_SESSION['id'];

if(sql_setOnlineUser($userid,true))
{
	header("location:chatClient.php");
}
else
{
	echo "<form action='login.php' method='post' name='frm'>								
				<input type='hidden' name='status' value='failed3' />				
			</form>
			<script language='javaScript'>
				document.frm.submit();
			</script>";					
}
?>