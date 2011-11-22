<?php
include_once('database.php');

session_start();
$id = $_SESSION['id'];

$display_num = 10;

foreach($_POST as $key => $value)
{
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	$$key = mysql_real_escape_string($value);
}

if($action == "postMsg")
{
	sql_query("insert into chatlog (sid, message, time) VALUES ('$id', '$msg', ".time().")");
}

if($action == "updateMsg" || $action == "postMsg"){
	$messages = sql_query("SELECT sid,message FROM chatlog WHERE time>$time");
	
	if(mysql_num_rows($messages) == 0){
		$status_code = 2;
	}
	else{
		$status_code = 1;
	}
	
	echo "<?xml version=\"1.0\"?>\n";
	echo "<response>\n";
	echo "\t<status>$status_code</status>\n";
	echo "\t<time>".time()."</time>\n";
	if($status_code == 1)
	{
		while($message = mysql_fetch_array($messages))
		{
			$message['message'] = htmlspecialchars(stripslashes($message['message']));
			$user = get_user($message["sid"]);
			echo "\t<message>\n";
			echo "\t\t<name>$user</name>\n";
			echo "\t\t<text>$message[message]</text>\n";
			echo "\t</message>\n";
		}
	}
	echo "</response>";	
}

if($action == "updateOnlineUsers"){
	$onlineUsers= sql_getOnlineUsers();
	while($db_field = mysql_fetch_assoc($onlineUsers))
	{
		echo "<li>".$db_field['username']."</li>";
	}
}
?>