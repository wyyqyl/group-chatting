<?php
include_once('database.php');
session_start();
$id = $_SESSION['id'];
$msg = $_POST['msg'];
if(sql_execute("insert into chatlog (sid, message) VALUES ('$id', '$msg')") == '1'){
	echo 'successfully';
}
?>