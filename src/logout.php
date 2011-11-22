<?php
include_once 'database.php';
session_start();
if(isset($_SESSION['id']))
{
	$userid = $_SESSION['id'];
	sql_setOnlineUser($userid, false);
	session_destroy();
	header("location:login.php");
}
else
{
	$userid = $_SESSION['id'];
	echo $userid;
	echo "failed";
}
?>
