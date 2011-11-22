<?php
include_once('database.php');
$users = array('ceo' => 'group',
				'manager1' => 'group',
				'manager2' => 'group',
				'attacker' => 'group');
$table = "membersinfo";
foreach($users as $name => $password){
	$salt = rand();
	$hash = hash_hmac('sha512', $password, $salt);
	$sql = "INSERT INTO $table (username, password, salt, role) VALUES ('$name', '$hash', '$salt', 'stuff')";
	$result = sql_query($sql);
	echo $result + '<br />';
}
?>