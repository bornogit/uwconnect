<?php
	function connect()
	{
		$server = "connect.microwebpla.net";
		$db = "connect";
		$user ="root";
		$password = "root";
		$tables = array(
			"users" => "users",
			"friends" => "friends",
			"messages" => "messages",
			"load" => "loadinfo"
		);
		
		
		$conn= mysql_connect($server, $user, $password);
		if (!$conn)
		{
			echo "Could not connect to database". mysql_error();
		}
		else
		{
			mysql_select_db($db,$conn);
			return $conn;
		}
	}

	/*
	if (!mysql_query($query, $conn))
			{
					die('Die :'.mysql_error());
					return false;
				}
	*/
?>