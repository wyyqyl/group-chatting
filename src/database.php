<?php
	function sql_execute($sql){
		
		$db_name = "group_chatting";
		
		mysql_connect("localhost", "root", "") or die("cannot connect");
		mysql_select_db($db_name) or die("cannot select DB");
		
		$sql = stripslashes($sql);
		// $sql = mysql_real_escape_string($sql);
		$rs = mysql_query($sql);	// return resource id
		
		return $rs;
	}
	
	function sql_deleteOnlineusers($id){
		
		$db_name = "group_chatting";
		
		mysql_connect("localhost", "root", "") or die("cannot connect");
		mysql_select_db($db_name) or die("cannot select DB");
		
		mysql_query("DELETE FROM onlineusers WHERE uid=".$id."");
		
		
	}

?>