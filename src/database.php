<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])){
	exit();
}
function sql_query($sql){
	$db_name = "group_chatting";

	mysql_connect("localhost", "root", "") or die("cannot connect");
	mysql_select_db($db_name) or die("cannot select DB");

	// $sql = stripslashes($sql);
	// $sql = mysql_real_escape_string($sql);
	$rs = mysql_query($sql);	// return resource id

	return $rs;
}

function sql_getdata($sql){
	$rs = sql_query($sql);
	return mysql_fetch_assoc($rs);
	//return mysql_fetch_array($rs);
}

//User
function get_user($id)
{
	$temp = sql_getdata("SELECT username FROM membersinfo WHERE id='$id'");
	return $temp['username'];
}

//Online Users
function sql_setOnlineUser($id,$online){
	$login = sql_getdata("SELECT login FROM membersinfo WHERE id='$id'");
	echo $login;
	if ($login['login']=="0" && $online==true) {
		sql_query("UPDATE membersinfo SET login='1' WHERE ID='$id'");
	}
	else if($login['login']=="1" && $online==true)
	{
		errorMessageToLogin("Another user has attempted to log in using your account. For security purposes, your session will be signed out.");
	}
	else if($login['login']=="0" && $online==false)
	{
		sql_query("UPDATE membersinfo SET login='0' WHERE ID='$id'");
	}
	else if($login['login']=="1" && $online==false)
	{
		sql_query("UPDATE membersinfo SET login='0' WHERE ID='$id'");
	}
	else
	{
		sql_query("UPDATE membersinfo SET login='0' WHERE ID='$id'");
	}
	return true;
}

function sql_getOnlineUser($id){
	$login = sql_getdata("SELECT login FROM membersinfo WHERE id='$id'");
	return $login['login'];
}

function sql_getOnlineUsers(){
	$onlineUsers = sql_query("SELECT username FROM membersinfo WHERE login=1");
	return $onlineUsers;
}

function sql_getUsers(){
	$users = sql_query("SELECT username FROM membersinfo");
	return $users;
}

function errorMessageToLogin($msg)
{
	echo "<form action='login.php' method='post' name='frm'>								
				<input type='hidden' name='status' value='".$msg."' />				
			</form>
			<script language='javaScript'>
				document.frm.submit();
			</script>";		
}
?>